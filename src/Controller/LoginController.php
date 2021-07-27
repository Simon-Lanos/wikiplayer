<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LoginController
 * @package App\Controller
 * @Route(name="login_")
 */
class LoginController extends AbstractController
{
    /**
     * @Route("/connect-wiki-oauth", name="connect_wiki_oauth")
     * @return Response
     */
    public function connectWiki(ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry
            ->getClient('wiki_oauth') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect([], []);
    }
    /**
     * @Route("/check-wiki-oauth", name="check_wiki_oauth")
     * @return Response
     */
    public function checkWiki(): Response
    {
        return new Response();
    }
}
