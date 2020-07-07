<?php

namespace App\Controller;

use App\Entity\Artefacts;
use App\Form\ArtefactsType;
use App\Form\ProfileUserType;
use App\Repository\ArtefactsRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/artefacts")
 */
class ArtefactsController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    /**
     * @Route("/", name="artefacts_index", methods={"GET"})
     */
    public function index(ArtefactsRepository $artefactsRepository): Response
    {
        $user = $this->security->getUser();

        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return $this->render('artefacts/index.html.twig', [
                'artefacts' => $artefactsRepository->findAll(),
            ]);
        }
        return $this->render('artefacts/index.html.twig', [
            'artefacts' => $artefactsRepository->findBy(
                array('user' => $user)
            ),
        ]);
    }

    /**
     * @Route("/edit_profile", name="edit_profile", methods={"GET","POST"})
     *
     */
    public function editProfile(Request $request): Response
    {
        $user = $this->security->getUser();
        $form = $this->createForm(ProfileUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('artefacts');
        }

        return $this->render('artefacts/edit_profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="artefacts_new", methods={"GET","POST"})
     *
     * @param Request $request
     * @param LoggerInterface $logger
     *
     * @throws Exception
     *
     * @return Response
     */
    public function new(Request $request, LoggerInterface $logger)
    {
        $artefact = new Artefacts();
        $form     = $this->createForm(ArtefactsType::class, $artefact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();
            if ($image) {
                $imageName = "{$image->getFilename()}.{$image->guessExtension()}";
                $imagesDir = $this->getParameter('artefact_uploads');
                $image->move($imagesDir, $imageName);

                $artefact->setImage($imageName);
            }

            try {
                $em->persist($artefact);
                $em->flush();
            } catch (Exception $e) {
                $message = "Couldn't save artefact: {$e->getMessage()}";
                $logger->critical($message);

                throw new Exception($message);
            }

            return $this->redirectToRoute('artefacts_index');
        }

        return $this->render('artefacts/new.html.twig', [
            'artefact' => $artefact,
            'form'     => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artefacts_show", methods={"GET"})
     */
    public function show(Artefacts $artefact): Response
    {
        return $this->render('artefacts/show.html.twig', [
            'artefact' => $artefact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="artefacts_edit", methods={"GET","POST"})
     *
     * @param Request         $request
     * @param Artefacts       $artefact
     * @param LoggerInterface $logger
     *
     * @throws Exception
     *
     * @return Response
     */
    public function edit(Request $request, Artefacts $artefact, LoggerInterface $logger)
    {
        $form = $this->createForm(ArtefactsType::class, $artefact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();
            if ($image) {
                $imageName = "{$image->getFilename()}.{$image->guessExtension()}";
                $imagesDir = $this->getParameter('artefact_uploads');
                $image->move($imagesDir, $imageName);

                $artefact->setImage($imageName);
            }

            try {
                $em->persist($artefact);
                $em->flush();
            } catch (Exception $e) {
                $message = "Couldn't update artefact: {$e->getMessage()}";
                $logger->critical($message);

                throw new Exception($message);
            }

            return $this->redirectToRoute('artefacts_index');
        }

        return $this->render('artefacts/edit.html.twig', [
            'artefact' => $artefact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artefacts_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Artefacts $artefact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artefact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artefact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('artefacts_index');
    }
}
