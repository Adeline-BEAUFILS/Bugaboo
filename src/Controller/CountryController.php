<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Country;
use App\Entity\Killer;
use App\Repository\KillerRepository;
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
     * @Route("/show/{countryName}", methods={"GET"}, name="show")
     * @return Response
     */
    public function show(string $countryName): Response
    {   
        $country = $this->getDoctrine()
        ->getRepository(Country::class)
        ->findOneBy(['name' => $countryName]);

    if (!$country) {
        throw $this->createNotFoundException(
            'No country with name : '.$countryName.' found in killers table.'
        );
    }
        $killers = $this->getDoctrine()
        ->getRepository(Killer::class)
        ->findBy(
        ['country'=> $country],
        ['id' => 'DESC'],
        10
        );

    return $this->render('country/show.html.twig', [
        'country' => $country, 'killers' => $killers
    ]);
    }

    /**
     * @Route("/new", methods={"GET","POST"}, name="new")
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