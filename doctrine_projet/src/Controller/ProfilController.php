<?php

namespace App\Controller;

use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil/create', name: 'profil_create')]
    public function createProfil(EntityManagerInterface $entityManager): Response
    {
        $profil = new Profil();
        $profil->setName('Jean Dupont');
        $profil->setJobTitle('Développeur Symfony');
        $profil->setSummary('Passionné par le développement et la technologie.');
        $profil->setSalary(45000);
        $entityManager->persist($profil);
        $entityManager->flush();
        return new Response('Profil créé avec l\'ID ' . $profil->getId());
    }

    #[Route('/profil/list', name: 'profil_list')]
    public function listProfils(EntityManagerInterface $entityManager): Response
    {
        $profils = $entityManager->getRepository(Profil::class)->findAll();
        $responseContent = '';
        foreach ($profils as $profil) {
            $responseContent .= $profil->getName() . ' - ' . $profil->getJobTitle() . ' - '
                . $profil->getSalary() . '€<br>';
        }
        return new Response($responseContent);
    }
}
