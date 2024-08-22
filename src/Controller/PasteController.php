<?php

namespace App\Controller;

use App\Entity\Paste;
use App\Form\PasteType;
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
        $form = $this->createForm(PasteType::class, $paste);
        return $this->render('paste/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/', name: 'app_create_paste')]
    public function create(Request $request): Response
    {
        $paste = new Paste();
        $form = $this->createForm(PasteType::class, $paste);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $paste = $form->getData();
            dump($paste);
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_paste');
        }

        return $this->render('paste/index.html.twig', [
            'form' => $form,
        ]);
    }
}
