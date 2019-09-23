<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Specialist;
use App\Entity\Visit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class AdmController extends AbstractController
{
    /**
     * @Route("/administrator", name="adm")
     */
    public function index()
    {
        return $this->render('adm/index.html.twig', [
            'controller_name' => 'AdmController',
        ]);
    }

    /**
     * @Route("/administrator", name="adm", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {
        $client = new Client();

        $form = $this->createFormBuilder($client)
            ->add('firstname', TextType::class, array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'Enter your firstname'),
            ))
            ->add('surname', TextType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Enter your surname')
            ))
            ->add('age', IntegerType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control', 'placeholder' => 'Enter your age'),
            ))
            ->add('specialist', EntityType::class, array(
                'class' => Specialist::class,
                'attr' => array('class' => 'form-control'),
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', 'Užregistruota sėkmingai');

            $client = $form->getData();

            $visit = new Visit();
            $visit->setEvent('created');
            $visit->setCreatedAt();
            $visit->setClient($client);
            $visit->setSpecialist($client->getSpecialist());


            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($client);
            $entityManager->persist($visit);

            $entityManager->flush();

            return $this->redirectToRoute('home_page');
        }

        elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Įvyko klaida, kreipkitės telefonu');
            return $this->render('adm/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }


        return $this->render('adm/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
