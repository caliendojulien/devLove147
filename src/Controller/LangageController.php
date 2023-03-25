<?php

namespace App\Controller;

use App\Entity\Langage;
use App\Form\LangageType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/langage", name: "langage_")]
class LangageController extends AbstractController
{
    #[IsGranted("ROLE_ADMIN")]
    #[Route("/ajouter", name: "ajouter")]
    public function ajouter(Request $request, EntityManagerInterface $manager): Response
    {
        $langage = new Langage();
        $langageForm = $this->createForm(LangageType::class, $langage);
        $langageForm->handleRequest($request);
        if ($langageForm->isSubmitted() && $langageForm->isValid()) {
            $manager->persist($langage);
            $manager->flush();
        }
        return $this->render('langage/ajouter.html.twig',
            compact("langageForm")
        );
    }
}
