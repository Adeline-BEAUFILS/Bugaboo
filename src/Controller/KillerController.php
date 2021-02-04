<?php

namespace App\Controller;

use App\Entity\Killer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\KillerType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\KillerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Service\Slugify;

/**
 * @Route("/killers", name="killer_")
 */

class KillerController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {   
        $killers = $this->getDoctrine()
        ->getRepository(Killer::class)
        ->findAll();

        return $this->render('killer/index.html.twig', [
            'killers' => $killers,
        ]);
    }

    /**
     * @Route("/show/{id<^[0-9]+$>}", name="show")
     * @return Response
     */
    public function show(int $id): Response
    {   
        $killer = $this->getDoctrine()
        ->getRepository(Killer::class)
        ->findOneBy(['id' => $id]);

    if (!$killer) {
        throw $this->createNotFoundException(
            'No killer with id : '.$id.' found in killers table.'
        );
    }
    return $this->render('killer/show.html.twig', [
        'killer' => $killer,
    ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, Slugify $slugify): Response
    {   
        $killer = new Killer();
        $form = $this->createForm(KillerType::class, $killer);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $slug = $slugify->generate($killer->getName());
            $killer->setSlug($slug);
            $entityManager->persist($killer);
            $entityManager->flush();

            return $this->redirectToRoute('killer_index');
        }
        return $this->render('killer/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit", name="killer_edit", methods={"GET","POST"})
     * @ParamConverter("killer", class="App\Entity\Killer")
     */
    public function edit(Request $request, Killer $killer): Response
    {   
        $form = $this->createForm(KillerType::class, $killer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('killer_index');
        }

        return $this->render('killer/edit.html.twig', [
            'killer' => $killer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="killer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Killer $killer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$killer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($killer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('killer_index');
    }
}
