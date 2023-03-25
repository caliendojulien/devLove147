<?php

namespace App\Controller;

use App\Entity\Developpeur;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\DeveloppeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route("/message{id}", name: "message_index")]
    public function index(Developpeur $developpeur, Request $request, DeveloppeurRepository $developpeurRepository, MailerInterface $mailer): Response
    {
        $moi = $developpeurRepository->findOneBy(["email" => $this->getUser()->getUserIdentifier()]);
        $message = new Message();
        $messageForm = $this->createForm(MessageType::class, $message);
        $messageForm->handleRequest($request);
        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $mail = (new Email())
                ->from($moi->getEmail())
                ->to($developpeur->getEmail())
                ->subject($message->getSujet())
                ->text($message->getCorps());
            $mailer->send($mail);
            $this->addFlash("success", "Le mail a bien été envoyé.");
            return $this->redirectToRoute("dev_index");
        }
        return $this->render("message/index.html.twig", compact("messageForm"));
    }
}
