<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Specialist;
use App\Entity\Visit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SpecialistController extends AbstractController
{
    /**
 * @Route("/specialist", name="specialist")
 */
    public function index()
    {
        $specialists = $this->getDoctrine()
            ->getRepository(Specialist::class)
            ->findAll();

        return $this->render('specialist/index.html.twig', [
            'specialists' => $specialists,
        ]);
    }

    /**
     * @Route("/specialist/{id}", name="specialistSelected")
     */
    public function showAllBySpecialist(int $id)
    {
        $clients = $this->getDoctrine()
            ->getRepository(Client::class)
            ->findBy(['serviced' => null, 'specialist' => $id]);

        return $this->render('specialist/filtered_clients.html.twig', [
            'clients' => $clients,
        ]);
    }

    /**
     * @Route("/served/{id}", name="servedClient")
     */
    public function markServedClient(Client $client)
    {
        $client->setServiced(true);

        $visit = new Visit();
        $visit->setEvent('served');
        $visit->setCreatedAt();
        $visit->setClient($client);
        $visit->setSpecialist($client->getSpecialist());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($client);
        $entityManager->persist($visit);
        $entityManager->flush();

        return $this->redirectToRoute('specialistSelected', [
            'id' => $client->getSpecialist()->getId()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="deleteClient")
     */
    public function deleteClient(Client $client)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($client);
        $entityManager->flush();

        return $this->redirectToRoute('home_page');
    }

    /**
     * @Route("/list/specialist", name="specialist_list")
     */
    public function showSpecialistList()
    {
        $specialists = $this->getDoctrine()
            ->getRepository(Specialist::class)
            ->findAll();

        return $this->render('specialist/list_display.html.twig', [
            'specialists' => $specialists,
        ]);
    }

    /**
     * @Route("/new/specialist", name="specialistnew", methods={"GET", "POST"})
     */
    public function createNewSpecialist(Request $request)
    {
        $specialist = new Specialist();

        $form = $this->createFormBuilder($specialist)
            ->add('title', TextType::class, array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'Enter specialist title')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $specialist = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($specialist);
            $entityManager->flush();

            return $this->redirectToRoute('specialist_list');
        }

        return $this->render('specialist/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/statistics", name="specialistStats")
     */
    public function displayStatistics()
    {
        $conn = $this->getDoctrine()->getConnection();

        $sql = 'select title, date(tt.created_at) as day, floor(avg(time_diff)) as service_avg
                from (
                         select t.client_id, t.specialist_id, v.created_at, title, time_diff
                         from (
                                  select client_id, visit.specialist_id, s.title, created_at, timestampdiff(second , lag(created_at) over (partition by client_id order by client_id), created_at) as time_diff
                                  from visit
                                           left join client c on visit.client_id = c.id
                                           left join specialist s on c.specialist_id = s.id
                                  where serviced is not null ) t
                                  left join visit v on v.client_id = t.client_id
                         where t.time_diff is not null and event=\'created\' ) tt
                group by 1, 2
                order by 2 desc, 1';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $specialists = $stmt->fetchAll();

        return $this->render('specialist/statistics.html.twig', [
            'specialists' => $specialists,
        ]);
    }
}
