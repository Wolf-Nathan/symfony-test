<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Repository\MedecinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/medecin")
 */
class MedecinController extends AbstractController
{
    const MOIS = array(
        '1' => 'janvier',
        '2' => 'février',
        '3' => 'mars',
        '4' => 'avril',
        '5' => 'mai',
        '6' => 'juin',
        '7' => 'juillet',
        '8' => 'août',
        '9' => 'septembre',
        '10' => 'octobre',
        '11' => 'novembre',
        '12' => 'décembre',
        '01' => 'janvier',
        '02' => 'février',
        '03' => 'mars',
        '04' => 'avril',
        '05' => 'mai',
        '06' => 'juin',
        '07' => 'juillet',
        '08' => 'août',
        '09' => 'septembre',
    );

    /**
     * @Route("/", name="medecin_index", methods={"GET"})
     */
    public function index(MedecinRepository $medecinRepository): Response
    {
        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecinRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="medecin_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $medecin = new Medecin();
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medecin);
            $entityManager->flush();

            return $this->redirectToRoute('medecin_index');
        }

        return $this->render('medecin/new.html.twig', [
            'medecin' => $medecin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medecin_show", methods={"GET"})
     */
    public function show(Medecin $medecin): Response
    {
        return $this->render('medecin/show.html.twig', [
            'medecin' => $medecin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="medecin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Medecin $medecin): Response
    {
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medecin_index');
        }

        return $this->render('medecin/edit.html.twig', [
            'medecin' => $medecin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medecin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Medecin $medecin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medecin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medecin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medecin_index');
    }

    /**
     * @Route("/{id}/consultation/{month}/{year}", name="medecin_consultation", methods={"GET"})
     */
    public function consultation(Request $request, Medecin $medecin): Response
    {
        $month = $request->get('month');
        $year = $request->get('year');
        if(isset($_POST['dateConsult'])){
            $dateConsult = $_POST['dateConsult'];
            $separe = explode('-', $dateConsult);
            $month = $separe[1];
            $year  = $separe[0];
        }
        $consultations = $medecin->getConsultations();
        $consulInfo = [];
        foreach($consultations as $consultation){
            $consulMonth = $consultation->getDateHeure()->format('m');
            $consulYear = $consultation->getDateHeure()->format('Y');
            if(($consulMonth == $month && $consulYear == $year) || !($month || $year)) {
                $id = $consultation->getId();
                $consulInfo[$id]['patient'] = $consultation->getPatient()->__toString();
                $consulInfo[$id]['date'] = $consultation->getDateHeure()->format('d/m/Y H:i');
            }
        }
        return $this->render('medecin/consultation.html.twig', [
            'medecin' => $medecin,
            'consultations' => $consulInfo,
            'month' => $month,
            'year' => $year,
            'mois' => self::MOIS
        ]);
    }
}
