<?php

namespace App\Controller;

use App\Entity\Archive;
use App\Form\ConfigUploadFormType;
use App\Repository\ArchiveRepository;
use App\Services\ConfigFilesServices;
use Doctrine\ORM\EntityManagerInterface;
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
    public function upload(Request $request, ConfigFilesServices $configFilesServices, ArchiveRepository $archiveRepository, EntityManagerInterface $entityManager): Response
    {
        $hasArchive = !$this->getUser()->getArchives()->isEmpty();
        if($hasArchive){
            $archive = $archiveRepository->findOneBy(['upload_by' => $this->getUser()]);
            $archiveName = explode('.', $archive->getFilename())[0];
            $archiveExtension = explode('.', $archive->getFilename())[1];
            $archiveDate = $archive->getUploadDate();
            $configFiles = scandir('upload/config/extract/' . $archiveName);
            $configFiles = array_slice($configFiles, 2);
        } else {
            $uploadForm = $this->createForm(ConfigUploadFormType::class);
            $uploadForm->handleRequest($request);
            if ($uploadForm->isSubmitted() && $uploadForm->isValid()) {
                $this->addFlash('success', 'Upload de la configuration terminé.');
                $config = $uploadForm->get('config')->getData();
                $fileName = $this->getUser()->getId() . '_' . $this->getUser()->getUsername() . '_' . date("Y-m-d-H-i-s");
                $extension = $config->guessExtension();
                $path = 'upload/config/zip/' . $fileName . '.' . $extension;
                $config->move('upload/config/zip/', $fileName . '.' . $extension);
                $configFilesServices->extractArchive($path);
                $archive = new Archive();
                $archive->setFilename($fileName . '.' . $extension);
                $archive->setUploadDate(date_create(date("Y-m-d H:i:s")));
                $archive->setUploadBy($this->getUser());
                $archive->setRelatedTo($this->getUser());
                $archive->setStatus('pending');
                $entityManager->persist($archive);
                $entityManager->flush();
                return $this->redirectToRoute('upload');
            } elseif ($uploadForm->isSubmitted() && !$uploadForm->isValid()) {
                $this->addFlash('error', 'Erreur d\'upload du fichier');
                return $this->redirectToRoute('upload');
            }
        }

        return $this->render('main/upload.html.twig', [
            'uploadForm' => isset($uploadForm) ? $uploadForm->createView() : null,
            'hasArchive' => $hasArchive ?? false,
            'configFiles' => $configFiles ?? null,
            'folder' => $hasArchive ? $archiveName : null,
            'archiveExtension' => $hasArchive ? $archiveExtension : null,
            'archiveDate' => $hasArchive ? $archiveDate : null,
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
