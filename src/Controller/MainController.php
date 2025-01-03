<?php

namespace App\Controller;

use App\Form\ConfigUploadFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function upload(Request $request): Response
    {
        $uploadForm = $this->createForm(ConfigUploadFormType::class);
        $uploadForm->handleRequest($request);

        if($uploadForm->isSubmitted() && $uploadForm->isValid()) {
            $this->addFlash('success', 'Upload de la configuration terminé.');
            $config = $uploadForm->get('config')->getData();
            $config->move('upload/config', $this->getUser()->getId() . '.' . $config->guessExtension());
            return $this->redirectToRoute('upload');
        } elseif($uploadForm->isSubmitted() && !$uploadForm->isValid()) {
            $this->addFlash('error', 'Erreur d\'upload du fichier');
            return $this->redirectToRoute('upload');
        }

        return $this->render('main/upload.html.twig', [
            'uploadForm' => $uploadForm->createView(),
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
