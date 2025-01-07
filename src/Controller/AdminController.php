<?php

namespace App\Controller;

use App\Form\EditHomePageFormType;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
        ]);
    }

    #[Route('/admin/edit/home', name: 'admin_edit_home')]
    public function editHome(PageRepository $pageRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $homepage = $pageRepository->findOneBy(['title' => 'index']);
        $editForm = $this->createForm(EditHomePageFormType::class, $homepage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $homepage->setContent($editForm->get('content')->getData());
            $entityManager->persist($homepage);
            $entityManager->flush();
            $this->addFlash('success', 'Modifications prises en compte');
            $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/edit_home.html.twig', [
            'editForm' => $editForm->createView(),
        ]);
    }
}
