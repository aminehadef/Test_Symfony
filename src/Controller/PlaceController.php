<?php

namespace App\Controller;

use App\Entity\Place;
use App\Form\CsvType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlaceController extends AbstractController
{
    /**
     * @Route("/place", name="display_place")
     */
    public function displayPlace(Request $request, ObjectManager $manager)
    {

        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $repository = $this->getDoctrine()->getRepository(Place::class);
        $places = $repository->findAll();

        $form = $this->createForm(CsvType::class);
        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()){
           
            $file = $form['file_scv']->getData();
            $file->move("./csv", "palce.csv", $file->getClientOriginalName());

            $handle = @fopen('./csv/palce.csv','r');
            set_time_limit(0);
            while (($data = fgetcsv($handle, 0, ";"))){
                $place = new Place();
                $place->setName($data[0])
                      ->setAddress($data[1])
                      ->setZipCode($data[2])
                      ->setCity($data[3]);

                $manager->persist($place);
                $manager->flush();
            }
        }


        return $this->render('place/displayPlace.html.twig', [
            'controller_name' => 'PlaceController',
            'places' => $places,
            'form' => $form->createView(),
        ]);
    }
}
