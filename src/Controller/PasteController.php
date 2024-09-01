<?php

namespace App\Controller;

use App\Entity\Paste;
use App\Form\PasteType;
use App\Repository\PasteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PasteController extends AbstractController
{
    #[Route('/', name: 'app_paste')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $rep = $entityManager->getRepository(Paste::class);
        $list = $rep->pagination(0, 10);
        if ($user) {
            $listPrivate = $rep->paginationPrivate(0, 10, $user);
        }
        $paste = new Paste();
        $form = $this->createForm(PasteType::class, $paste, ['action' => $this->generateUrl('app_create_paste')]);

        $viewData = [
            'form' => $form,
            'list' => $list,
            'login' => $user ? true : false,
            'list_private' => $listPrivate ?? false
        ];
        return $this->render('paste/index.html.twig', $viewData);
    }

    #[Route('/paste/', name: 'app_create_paste', methods: ['POST'])]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $paste = new Paste();
        $form = $this->createForm(PasteType::class, $paste);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $paste = $form->getData();
            $user = $this->getUser();
            if ($user) {
                $paste->setUser($user);
            }
            $entityManager->persist($paste);
            $entityManager->flush();
            return $this->redirectToRoute('app_paste');
        }

        return $this->render('paste/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/paste/{slug}', name: 'show_paste', methods: ['GET'])]
    public function show(EntityManagerInterface $entityManager, string $slug): Response
    {
        $user = $this->getUser();
        $rep = $entityManager->getRepository(Paste::class);

        if ($slug) {
            $paste = $rep->findBySlug($slug)[0];
        } else {
            $paste = new Paste();
        }
        $form = $this->createForm(PasteType::class, $paste, ['action' => $this->generateUrl('app_create_paste')]);

        $list = $rep->pagination(0, 10);
        if ($user) {
            $listPrivate = $rep->paginationPrivate(0, 10, $user);
        }

        return $this->render('paste/show.html.twig', [
            'form' => $form,
            'list' => $list,
            'login' => $user ? true : false,
            'list_private' => $listPrivate ?? false
        ]);
    }
}
