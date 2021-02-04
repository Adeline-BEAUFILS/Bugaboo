<?php

namespace App\Controller;

use App\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CountryType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/countries", name="country_")
 */

class CountryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {   
        $countries = $this->getDoctrine()
        ->getRepository(Country::class)
        ->findAll();

        return $this->render('country/index.html.twig', [
            'countries' => $countries,
        ]);
    }

    /**
     * @Route("/show/{id<^[0-9]+$>}", name="show")
     * @return Response
     */
    public function show(int $id): Response
    {   
        $country = $this->getDoctrine()
        ->getRepository(Country::class)
        ->findOneBy(['id' => $id]);

    if (!$country) {
        throw $this->createNotFoundException(
            'No country with id : '.$id.' found in countries table.'
        );
    }
    return $this->render('country/show.html.twig', [
        'country' => $country,
    ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request): Response
    {   
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($country);
            $entityManager->flush();

            return $this->redirectToRoute('country_index');
        }
        return $this->render('country/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }
}