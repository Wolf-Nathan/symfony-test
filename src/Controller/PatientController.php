<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Patient;
use App\Entity\Consultation;

class PatientController extends AbstractController
{
    /**
     * @Route("/patient", name="patient")
     */
    public function index()
    {
        $patient = new Patient;
        //Hydratation de l'instance de l'entité Patient
        $patient->setNumSS('168077511115369');
        $patient->setNom('Dupond');
        $patient->setPrenom('Jacques');
        $maDate = new \DateTime('1978-07-18');
        $patient->setDateNaissance($maDate);
        $patient->setSexe('M');

        // Créations de consultations
        $consultation = new Consultation;
        $heureConsult = new \DateTime('now');
        $consultation->setDateHeure($heureConsult);
        $consultation->setPatient($patient);

        $patient->addConsultation($consultation);

        // Récupération du service Doctrine.
        $doctrine = $this->getDoctrine();
        // Récupération du service gestionnaire d'entités
        $entityManager = $doctrine->getManager();
        $entityManager->persist($consultation);
        $entityManager->persist($patient);
        $entityManager->flush();

        return $this->render('patient/index.html.twig', [
            'controller_name' => 'Nouveau patient créé',
        ]);
    }

    /**
     * @Route("/patient/list", name="patient_list")
     */
    public function list(){
        $patientRepository = $this->getDoctrine()->getManager()->getRepository(Patient::class);
        $patients = $patientRepository->findAll();


        return $this->render('patient/list.html.twig', [
            'controller_name' => 'Liste des patients',
            'patients' => $patients
        ]);
    }
}
