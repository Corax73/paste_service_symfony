<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PasteController extends AbstractController
{
    #[Route('/paste', name: 'app_paste')]
    public function index(): Response
    {
        return $this->render('paste/index.html.twig', [
            'controller_name' => 'PasteController',
        ]);
    }
}
