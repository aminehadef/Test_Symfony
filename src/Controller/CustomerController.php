<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController
{

    /**
     * @Route("/customer", name="display_customer")
     */
    public function displayCustomer(){

        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $repository = $this->getDoctrine()->getRepository(Customer::class);
        $customers = $repository->findAll();

        return $this->render('customer/displayCustomer.html.twig', [
            'customers' => $customers,
        ]);
    }

    /**
     * @Route("/customer/register", name="customer_register")
     */
    public function registerCustomer(Request $request, ObjectManager $manager)
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $customer = new Customer();

        $form_customer = $this->createForm(CustomerType::class, $customer);
        $form_customer->handleRequest($request);

        if($form_customer->isSubmitted() && $form_customer->isValid()){

            
            $manager->persist($customer);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Client enregister avec succès ;)'
            );

            return $this->redirectToRoute('display_customer');
        }

        return $this->render('customer/registerCustomer.html.twig', [
            'controller_name' => 'CustomerController',
            'form_customer' => $form_customer->createView()
        ]);
    }

    /**
     * @Route("/customer/drop/{id}", name="customer_drop")
     */
    public function dropCustomer($id, ObjectManager $manager){

        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);

        $manager->remove($customer);
        $manager->flush();

        $this->addFlash(
            'notice',
            'Client supprimé avec succès ;)'
        );

        return $this->redirectToRoute('display_customer');
    }
    /**
     * @Route("/customer/edit/{id}", name="customer_edit")
     */
    public function editCustomer($id, Request $request, ObjectManager $manager){

        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        
        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);
        $form_customer = $this->createForm(CustomerType::class, $customer);
        $form_customer->handleRequest($request);
        if($form_customer->isSubmitted() && $form_customer->isValid()){
            
            $manager->persist($customer);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Client editer avec succès ;)'
            );

            return $this->redirectToRoute('display_customer');
        }

        return $this->render('customer/editCustomer.html.twig',[
            'form_customer' => $form_customer->createView(),
            'customer' => $customer
        ]);
    }
}
