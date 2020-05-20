<?php

namespace App\Controller;

use App\Entity\Prizn;
use App\Form\PriznType;
use App\Repository\PriznRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/prizn")
 */
class PriznController extends AbstractController
{
    /**
     * @Route("/", name="prizn_index", methods={"GET"})
     */
    public function index(PriznRepository $priznRepository): Response
    {
        return $this->render('prizn/index.html.twig', [
            'prizns' => $priznRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="prizn_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $prizn = new Prizn();
        $form = $this->createForm(PriznType::class, $prizn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prizn);
            $entityManager->flush();

            return $this->redirectToRoute('prizn_index');
        }

        return $this->render('prizn/new.html.twig', [
            'prizn' => $prizn,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prizn_show", methods={"GET"})
     */
    public function show(Prizn $prizn): Response
    {
        return $this->render('prizn/show.html.twig', [
            'prizn' => $prizn,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prizn_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Prizn $prizn): Response
    {
        $form = $this->createForm(PriznType::class, $prizn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prizn_index');
        }

        return $this->render('prizn/edit.html.twig', [
            'prizn' => $prizn,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="prizn_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Prizn $prizn): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prizn->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prizn);
            $entityManager->flush();
        }

        return $this->redirectToRoute('prizn_index');
    }
}
