<?php

namespace App\Controller;

use App\Entity\Hero;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{

    /**
     * @Route("/", name="Heroes")
     */
    public function heroes(Request $request): Response
    {
        $heroes = $this->getDoctrine()->getRepository(Hero::class)->findAll();
        return $this->json($heroes);
    }
}
