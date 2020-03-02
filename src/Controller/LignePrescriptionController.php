<?php

namespace App\Controller;

use App\Entity\LignePrescription;
use App\Form\LignePrescriptionType;
use App\Repository\LignePrescriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ligne/prescription")
 */
class LignePrescriptionController extends AbstractController
{
    /**
     * @Route("/", name="ligne_prescription_index", methods={"GET"})
     */
    public function index(LignePrescriptionRepository $lignePrescriptionRepository): Response
    {
        return $this->render('ligne_prescription/index.html.twig', [
            'ligne_prescriptions' => $lignePrescriptionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ligne_prescription_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lignePrescription = new LignePrescription();
        $form = $this->createForm(LignePrescriptionType::class, $lignePrescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lignePrescription);
            $entityManager->flush();

            return $this->redirectToRoute('ligne_prescription_index');
        }

        return $this->render('ligne_prescription/new.html.twig', [
            'ligne_prescription' => $lignePrescription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ligne_prescription_show", methods={"GET"})
     */
    public function show(LignePrescription $lignePrescription): Response
    {
        return $this->render('ligne_prescription/show.html.twig', [
            'ligne_prescription' => $lignePrescription,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ligne_prescription_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LignePrescription $lignePrescription): Response
    {
        $form = $this->createForm(LignePrescriptionType::class, $lignePrescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ligne_prescription_index');
        }

        return $this->render('ligne_prescription/edit.html.twig', [
            'ligne_prescription' => $lignePrescription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ligne_prescription_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LignePrescription $lignePrescription): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lignePrescription->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lignePrescription);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ligne_prescription_index');
    }
}
