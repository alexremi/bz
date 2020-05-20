<?php

namespace App\Controller;

use App\Entity\ZnPr;
use App\Form\ZnPrType;
use App\Repository\ZnPrRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/zn/pr")
 */
class ZnPrController extends AbstractController
{
    /**
     * @Route("/", name="zn_pr_index", methods={"GET"})
     */
    public function index(ZnPrRepository $znPrRepository): Response
    {
        return $this->render('zn_pr/index.html.twig', [
            'zn_prs' => $znPrRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="zn_pr_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $znPr = new ZnPr();
        $form = $this->createForm(ZnPrType::class, $znPr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($znPr);
            $entityManager->flush();

            return $this->redirectToRoute('zn_pr_index');
        }

        return $this->render('zn_pr/new.html.twig', [
            'zn_pr' => $znPr,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="zn_pr_show", methods={"GET"})
     */
    public function show(ZnPr $znPr): Response
    {
        return $this->render('zn_pr/show.html.twig', [
            'zn_pr' => $znPr,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="zn_pr_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ZnPr $znPr): Response
    {
        $form = $this->createForm(ZnPrType::class, $znPr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('zn_pr_index');
        }

        return $this->render('zn_pr/edit.html.twig', [
            'zn_pr' => $znPr,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="zn_pr_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ZnPr $znPr): Response
    {
        if ($this->isCsrfTokenValid('delete'.$znPr->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($znPr);
            $entityManager->flush();
        }

        return $this->redirectToRoute('zn_pr_index');
    }
}
