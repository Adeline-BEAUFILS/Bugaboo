<?php

namespace App\Controller;

use App\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function show(string $killerName): Response
    {   
        $country = $this->getDoctrine()
        ->getRepository(Country::class)
        ->findOneBy(['country' => $killerName]);

    if (!$country) {
        throw $this->createNotFoundException(
            'No killer with name : '.$killerName.' found in country table.'
        );
    }
    return $this->render('country/show.html.twig', [
        'country' => $killerName,
    ]);
    }
}