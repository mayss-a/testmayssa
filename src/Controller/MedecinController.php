<?php
namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Repository\MedecinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedecinController extends AbstractController
{
    #[Route('/medecin', name: 'app_medecin')]
    public function index(MedecinRepository $br, EntityManagerInterface $em): Response
    {
        // Récupérer tous les médecins
        $medecins = $br->findAll();

        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecins,
        ]);
    }

    #[Route('/medecin/add', name: 'app_medecin_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        // Nouvelle instance
        $medecin = new Medecin();
        // Formulaire
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($medecin);
            $em->flush();

            return $this->redirectToRoute('app_medecin');
        }

        return $this->render('medecin/add.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/medecin/edit/{id}', name: 'app_medecin_edit')]
    public function edit(Request $request, MedecinRepository $pr, int $id, EntityManagerInterface $em): Response
    {
        // Nouvelle instance
        $medecin = $pr->find($id);
        // Formulaire
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($medecin);
            $em->flush();

            return $this->redirectToRoute('app_medecin');
        }

        return $this->render('medecin/add.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/medecin/delete/{id}', name: 'app_medecin_delete')]
    public function delete(Request $request, MedecinRepository $pr, int $id, EntityManagerInterface $em): Response
    {
        // Création d'instance de classe
        $medecin = $pr->find($id);

        if ($medecin) {
            $em->remove($medecin);
            $em->flush();
        }

        return $this->redirectToRoute('app_medecin');
    }

    #[Route('/medecin/show/{id}', name: 'app_medecin_show')]
    public function show(Request $request, EntityManagerInterface $em, int $id, MedecinRepository $br): Response
    {
        $medecin = $br->find($id);

        return $this->render('medecin/show.html.twig', [
            "medecin" => $medecin
        ]);
    }

    #[Route('/medecin/search', name: 'search_medecin')]
    public function searchMedecins(MedecinRepository $medecinRepository): Response
    {
        $date1 = new \DateTime('2024-01-01');
        $date2 = new \DateTime('2024-12-31'); // Corrigez l'année ici pour être correcte

        // Utilisez le bon nom de variable
        $medecins = $medecinRepository->findMedecinsEntreDates($date1, $date2);

        return $this->render('medecin/medecinsearch.html.twig', [
            'medecins' => $medecins,
        ]);
    }
}
