<?php

namespace App\Controller;

use App\Entity\Hopital;
use App\Form\HopitalType;
use App\Repository\HopitalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HopitalController extends AbstractController
{
    #[Route('/hopital', name: 'app_hopital')]
    public function index(HopitalRepository $br): Response
    {

        $hopitaux =$br->findAll();
        return $this->render('hopital/index.html.twig', [
            'hopitaux' => $hopitaux
        ]);
    }

    #[Route('/hopital/add', name: 'app_hopital_add')]
    public function add(Request $request , EntityManagerInterface $em ): Response
    {
            //new instance
                $hopital = new Hopital ; 
            //formulaire
                $form = $this->createForm(HopitalType::class , $hopital) ; 
                $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $em->persist($hopital);
                $em->flush();

                return $this->redirectToRoute('app_hopital');
            }

       
        return $this->render('hopital/add.html.twig', [
             "form"=> $form->createView()
        ]);
    }


    #[Route('/hopital/edit/{id}', name: 'app_hopital_edit')]
    public function edit(  Request $request , HopitalRepository $pr ,int $id ,EntityManagerInterface $em ): Response
    {
            //création d'instance de classe
            $hopital = $pr->find($id)   ; 

            //  creation de formulaire
            $form = $this->createForm(HopitalType::class , $hopital); 
            $form->handleRequest($request) ; 

            if ($form->isSubmitted() ) {
                $em->persist($hopital);
                $em->flush() ;

                return $this->redirectToRoute('app_hopital');

            }
        return $this->render('hopital/add.html.twig', [
                'form'=> $form->createView()
        ]);
    }

    #[Route('/hopital/delete/{id}', name: 'app_hopital_delet')]
    public function delete(  Request $request , HopitalRepository $pr ,int $id ,EntityManagerInterface $em ): Response
    {
            //création d'instance de classe
            $hopital = $pr->find($id)   ; 

           
                $em->remove($hopital);
                $em->flush() ;

                return $this->redirectToRoute('app_hopital');

            
    }
    #[Route('/hopital/show/{id}', name: 'app_hopital_show')]
    public function show(Request $request , EntityManagerInterface $em , int $id ,HopitalRepository $br ): Response
    {
                 $hopital= $br->find($id) ; 

        return $this->render('hopital/show.html.twig', [
             "hopital"=>$hopital
        ]);
    }



}

