<?php

namespace App\Controller;

use App\Provider\WikiResourceOwner;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
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
     * @param ClientRegistry $clientRegistry
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
     * @param Request        $request
     * @param ClientRegistry $clientRegistry
     * @param RequestStack   $requestStack
     * @return Response
     */
    public function checkWiki(Request $request, ClientRegistry $clientRegistry, RequestStack $requestStack): Response
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        $client = $clientRegistry->getClient('wiki_oauth');

        try {
            // the exact class depends on which provider you're using
            /** @var WikiResourceOwner $user */
            $user = $client->fetchUser();

            $session = $requestStack->getSession();
            $session->set('user', $user->toArray());
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage());
        }

        return $this->redirectToRoute('statistics_index');
    }
}
