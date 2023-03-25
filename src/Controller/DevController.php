<?php

namespace App\Controller;

use App\Entity\Developpeur;
use App\Repository\DeveloppeurRepository;
use App\Repository\LangageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/dev', name: 'dev_')]
class DevController extends AbstractController
{
    #[Route("/index", name: "index")]
    public function index(DeveloppeurRepository $developpeurRepository, LangageRepository $langageRepository): Response
    {
        $listeDev = $developpeurRepository->findAll();
        $listeDesLangages = $langageRepository->findAll();
        return $this->render('dev/index.html.twig',
            compact("listeDev", "listeDesLangages")
        );
    }

    #[Route("/filtre/{param}", name:"filtre")]
    public function filtre(DeveloppeurRepository $developpeurRepository, LangageRepository $langageRepository, $param): Response
    {
        $listeDev = $developpeurRepository->findByLangage($param);
        $listeDesLangages = $langageRepository->findAll();
        return $this->render('dev/index.html.twig',
            compact("listeDev", "listeDesLangages")
        );
    }

    #[IsGranted("ROLE_USER")]
    #[Route("/ami/ajouter/{id}", name: "ajouter_ami")]
    public function ajouterAmi(Developpeur $developpeur, EntityManagerInterface $manager, DeveloppeurRepository $developpeurRepository): Response
    {
        $moi = $developpeurRepository->findOneBy(["email" => $this->getUser()->getUserIdentifier()]);
        $moi->addAmi($developpeur);
        $manager->persist($moi);
        $manager->flush();
        $this->addFlash("succes", $developpeur->getPseudo() . " a été ajouté en ami par " . $moi->getPseudo());
        return $this->redirectToRoute("dev_index");
    }

    #[IsGranted("ROLE_USER")]
    #[Route("/ami/retirer/{id}", name: "retirer_ami")]
    public function retirerAmi(Developpeur $developpeur, EntityManagerInterface $manager, DeveloppeurRepository $developpeurRepository): Response
    {
        $moi = $developpeurRepository->findOneBy(["email" => $this->getUser()->getUserIdentifier()]);
        $moi->removeAmi($developpeur);
        $manager->persist($moi);
        $manager->flush();
        $this->addFlash("succes", $developpeur->getPseudo() . " a été retiré des amis de " . $moi->getPseudo());
        return $this->redirectToRoute("dev_index");
    }

}
