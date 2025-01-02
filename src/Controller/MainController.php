<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
        ]);
    }

    #[Route('/upload', name: 'upload')]
    public function upload(): Response
    {
        return $this->render('main/upload.html.twig', [
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('main/contact.html.twig', [
        ]);
    }

    #[Route('/acount_edit', name: 'acount_edit')]
    public function acount_edit(): Response
    {
        return $this->render('main/acount_edit.html.twig', [
        ]);
    }
}
