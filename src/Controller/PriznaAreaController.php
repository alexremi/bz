<?php

namespace App\Controller;

use App\Entity\PriznaArea;
use App\Form\PriznaAreaType;
use App\Repository\PriznaAreaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/prizna/area")
 */
class PriznaAreaController extends AbstractController
{
    /**
     * @Route("/", name="prizna_area_index", methods={"GET"})
     */
    public function index(PriznaAreaRepository $priznaAreaRepository): Response
    {
        return $this->render('prizna_area/index.html.twig', [
            'prizna_areas' => $priznaAreaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="prizna_area_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $priznaArea = new PriznaArea();
        $form = $this->createForm(PriznaAreaType::class, $priznaArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($priznaArea);
            $entityManager->flush();

            return $this->redirectToRoute('prizna_area_index');
        }

        return $this->render('prizna_area/new.html.twig', [
            'prizna_area' => $priznaArea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prizna_area_show", methods={"GET"})
     */
    public function show(PriznaArea $priznaArea): Response
    {
        return $this->render('prizna_area/show.html.twig', [
            'prizna_area' => $priznaArea,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prizna_area_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PriznaArea $priznaArea): Response
    {
        $form = $this->createForm(PriznaAreaType::class, $priznaArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prizna_area_index');
        }

        return $this->render('prizna_area/edit.html.twig', [
            'prizna_area' => $priznaArea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prizna_area_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PriznaArea $priznaArea): Response
    {
        if ($this->isCsrfTokenValid('delete'.$priznaArea->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($priznaArea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prizna_area_index');
    }
}
