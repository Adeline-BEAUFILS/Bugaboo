<?php

namespace App\Controller;

use App\Entity\Killer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
