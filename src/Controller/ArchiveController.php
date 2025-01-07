<?php

namespace App\Controller;

use App\Repository\ArchiveRepository;
use App\Service\ArchiveService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArchiveController extends AbstractController
{
    #[Route('/archive/delete/{id}', name: 'delete_archive')]
    public function delete($id, ArchiveRepository $archiveRepository, ArchiveService $archiveService, EntityManagerInterface $entityManager): Response
    {
        $archive = $archiveRepository->find($id);
        $filename = $archive->getFilename();
        $folder = explode('.', $filename)[0];
        unlink('upload/config/zip/'.$filename);
        $archiveService->deleteFolder('upload/config/extract/'.$folder);
//        rmdir('upload/config/extract/'.$folder);
//        system("rm -rf ".escapeshellarg('upload/config/extract/'.$folder));
        $entityManager->remove($archive);
        $entityManager->flush();
        $this->addFlash('success', "Configuration supprimée");
        return $this->redirectToRoute('upload');
    }
}
