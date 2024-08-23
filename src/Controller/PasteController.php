<?php

namespace App\Controller;

use App\Entity\Paste;
use App\Form\PasteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PasteController extends AbstractController
{
    #[Route('/', name: 'app_paste')]
    public function index(): Response
    {
        $paste = new Paste();
        $form = $this->createForm(PasteType::class, $paste, ['action' => $this->generateUrl('app_create_paste')]);
        return $this->render('paste/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/paste/', name: 'app_create_paste', methods: ['POST'])]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $paste = new Paste();
        $form = $this->createForm(PasteType::class, $paste);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $paste = $form->getData();
            $entityManager->persist($paste);
            $entityManager->flush();
            return $this->redirectToRoute('app_paste');
        }

        return $this->render('paste/index.html.twig', [
            'form' => $form,
        ]);
    }
}
