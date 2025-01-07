<?php

namespace App\Controller;

use App\Form\UserFormType;
use App\Repository\UserRepository;
use App\Service\ArchiveService;
use App\Service\ImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user/edit/{id}', name: 'edit_user')]
    public function edit($id, UserRepository $userRepository, Request $request, ImageService $imageService, EntityManagerInterface $entityManager): Response
    {
        if($id == $this->getUser()->getId() || $this->getUser()->getId() == 1){
            $user = $userRepository->find($id);
            $userForm = $this->createForm(UserFormType::class, $user);
            $userForm->handleRequest($request);

            if ($userForm->isSubmitted() && $userForm->isValid()) {
                $user->setUsername($userForm->get('username')->getData());
                $user->setEmail($userForm->get('email')->getData());
                if($userForm->get('avatar')->getData()){
                    $user->setHasAvatar(true);
                    $imageService->uploadImages($userForm->get('avatar')->getData(), $user->getId(), 'avatar');
                }
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Modifications prises en compte');
                return $this->redirectToRoute('edit_user', ['id' => $user->getId()]);
            }

            return $this->render('user/edit.html.twig', [
                'userForm' => $userForm->createView(),
                'user' => $user,
            ]);
        } else{
            $this->addFlash('error', 'Vous n\'avez pas le droit de faire ça !');
            return $this->redirectToRoute('index');
        }
    }

    #[Route('/user/delete/{id}', name: 'delete_user')]
    public function delete($id, UserRepository $userRepository, ImageService $imageService, ArchiveService $archiveService, EntityManagerInterface $entityManager): Response
    {
        if ($id == $this->getUser()->getId() || $this->getUser()->getId() == 1) {
            $user = $userRepository->find($id);
            $imageService->deleteImages($user->getId(), 'avatar');
            if(!$this->getUser()->getArchives()->isEmpty()){
                foreach ($user->getArchives() as $archive){
                    $filename = $archive->getFilename();
                    $folder = explode('.', $filename)[0];
                    unlink('upload/config/zip/'.$filename);
                    $archiveService->deleteFolder('upload/config/extract/'.$folder);
                }
            }
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('succces', 'Utilisateur supprimé.');
            if($this->getUser()->getId() == 1){
                return $this->redirectToRoute('admin_index');
            } else {
                $this->container->get('security.token_storage')->setToken(null);
                return $this->redirectToRoute('index');
            }
        }
        $this->addFlash('error', 'Tu n\'as pas le droit de faire ça !');
        return $this->redirectToRoute('index');
    }
}
