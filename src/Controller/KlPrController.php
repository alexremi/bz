<?php

namespace App\Controller;

use App\Entity\KlPr;
use App\Form\KlPrType;
use App\Repository\KlPrRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/kl/pr")
 */
class KlPrController extends AbstractController
{
    /**
     * @Route("/", name="kl_pr_index", methods={"GET"})
     */
    public function index(KlPrRepository $klPrRepository): Response
    {
        return $this->render('kl_pr/index.html.twig', [
            'kl_prs' => $klPrRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="kl_pr_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $klPr = new KlPr();
        $form = $this->createForm(KlPrType::class, $klPr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($klPr);
            $entityManager->flush();

            return $this->redirectToRoute('kl_pr_index');
        }

        return $this->render('kl_pr/new.html.twig', [
            'kl_pr' => $klPr,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="kl_pr_show", methods={"GET"})
     */
    public function show(KlPr $klPr): Response
    {
        return $this->render('kl_pr/show.html.twig', [
            'kl_pr' => $klPr,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="kl_pr_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, KlPr $klPr): Response
    {
        $form = $this->createForm(KlPrType::class, $klPr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('kl_pr_index');
        }

        return $this->render('kl_pr/edit.html.twig', [
            'kl_pr' => $klPr,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="kl_pr_delete", methods={"DELETE"})
     */
    public function delete(Request $request, KlPr $klPr): Response
    {
        if ($this->isCsrfTokenValid('delete'.$klPr->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($klPr);
            $entityManager->flush();
        }

        return $this->redirectToRoute('kl_pr_index');
    }
}
