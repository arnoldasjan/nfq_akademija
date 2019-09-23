<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Specialist;
use App\Entity\Visit;
use App\Services\ServiceTimeCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(ServiceTimeCalculator $serviceTimeCalculator)
    {
        $clients = $this->getDoctrine()->getRepository(Client::class)->findBy(
            ['serviced' => null]
        );

        $visits = $this->getDoctrine()->getRepository(Visit::class)->findBy(
            ['event' => 'created', 'client' => $clients]
        );

        $allServiceTimes = $serviceTimeCalculator->calculateAvg();

        return $this->render('home_page/index.html.twig', [
            'clients' => $clients,
            'visits' => $visits,
            'serviceTimes' => $allServiceTimes,
        ]);
    }

    /**
     * @Route("/show/{id}", name="showClient")
     */
    public function show(int $id, ServiceTimeCalculator $serviceTimeCalculator)
    {
        $client = $this->getDoctrine()
            ->getRepository(Client::class)
            ->find($id);

        $visit = $this->getDoctrine()->getRepository(Visit::class)
            ->findBy(['client' => $client->getId(), 'event' => 'created']);

        $servicetime = $serviceTimeCalculator->avgForOneClient($client->getSpecialist()->getId());

        $servicetime = $servicetime['service_avg'];

        return $this->render('home_page/show.html.twig', [
            'client' => $client,
            'visit' => $visit,
            'avgtime' => $servicetime,
        ]);
    }

    /**
     * @Route("/find", name="findClient")
     */
    public function getOneClient(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('id', TextType::class, array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'Enter your id')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Find',
                'attr' => array('class' => 'btn btn-secondary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $obj = $form->getData();

            return $this->redirectToRoute('showClient', [
                'id' => $obj['id']
            ]);
        }

        return $this->render('home_page/find_client.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
