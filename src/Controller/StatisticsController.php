<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StatisticsController
 * @package App\Controller
 * @Route("/statistics", name="statistics_")
 */
class StatisticsController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();

        if (!$session->has('user')) {
            return $this->redirectToRoute('home_index');
        }

        return $this->render('statistics/index.html.twig', ['user' => $session->get('user')]);
    }
}
