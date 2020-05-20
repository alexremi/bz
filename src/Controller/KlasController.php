<?php

namespace App\Controller;

use App\Entity\Klas;
use App\Form\KlasType;
use App\Repository\KlasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/klas")
 */
class KlasController extends AbstractController
{
    /**
     * @Route("/", name="klas_index", methods={"GET"})
     */
    public function index(KlasRepository $klasRepository): Response
    {
        return $this->render('klas/index.html.twig', [
            'klas' => $klasRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="klas_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $kla = new Klas();
        $form = $this->createForm(KlasType::class, $kla);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($kla);
            $entityManager->flush();

            return $this->redirectToRoute('klas_index');
        }

        return $this->render('klas/new.html.twig', [
            'kla' => $kla,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="klas_show", methods={"GET"})
     */
    public function show(Klas $kla): Response
    {
        return $this->render('klas/show.html.twig', [
            'kla' => $kla,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="klas_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Klas $kla): Response
    {
        $form = $this->createForm(KlasType::class, $kla);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('klas_index');
        }

        return $this->render('klas/edit.html.twig', [
            'kla' => $kla,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="klas_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Klas $kla): Response
    {
        if ($this->isCsrfTokenValid('delete'.$kla->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($kla);
            $entityManager->flush();
        }

        return $this->redirectToRoute('klas_index');
    }
}
