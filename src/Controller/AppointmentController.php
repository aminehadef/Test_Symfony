<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Appointment;
use App\Form\AppointmentType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppointmentController extends AbstractController
{

    /**
     * @Route("/appointment", name="display_appointment")
     */
    public function displayAppointment(){

        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        
        $repository = $this->getDoctrine()->getRepository(Appointment::class);
        $appointments = $repository->findAll();

        return $this->render('appointment/displayAppointment.html.twig',[
            'appointments' => $appointments,
        ]);
    }

    /**
     * @Route("/appointment/register", name="appointment_register")
     */
    public function registerAppointment(Request $request, ObjectManager $manager)
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();        
        $appointemnt = new Appointment();

        $form = $this->createForm(AppointmentType::class, $appointemnt);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $data = $request->request->get('appointment');

            $repositoryCustomer = $this->getDoctrine()->getRepository(Customer::class);
            $customers = $repositoryCustomer->find($data['customer']);

            $appointemnt->setUser($user);
            $manager->persist($appointemnt);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Rendez-vous enregistrer avec succès ;)'
            );

            return $this->redirectToRoute('display_appointment');
        }


        return $this->render('appointment/registerAppointment.html.twig', [
            'controller_name' => 'AppointmentController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/appointment/edit/{id}", name="appointment_edit")
     */
    public function editAppointment($id, Request $request, ObjectManager $manager){

        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $appointemnt = $this->getDoctrine()->getRepository(Appointment::class)->find($id);
        $form = $this->createForm(AppointmentType::class, $appointemnt);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($appointemnt);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Rendez-vous editer avec succès ;)'
            );

            return $this->redirectToRoute('display_appointment');
        }
        return $this->render('appointment/editAppointment.html.twig',[
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/appointment/drop/{id}", name="appointment_drop")
     */
    public function dropAppointment($id, ObjectManager $manager){

        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $appointment = $this->getDoctrine()->getRepository(Appointment::class)->find($id);

        $manager->remove($appointment);
        $manager->flush();

        $this->addFlash(
            'notice',
            'Rendez-vous supprimé avec succès ;)'
        );

        return $this->redirectToRoute('display_appointment');
    }
}
