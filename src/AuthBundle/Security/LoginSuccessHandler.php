<?php
/**
 * Created by PhpStorm.
 * User: ODevS-Inc
 * Date: 9/16/2017
 * Time: 2:30 PM
 */

namespace AuthBundle\Security;


use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{

    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var Session
     */
    private $session;

    /**
     * @var Container
     */
    private $container;

    /**
     * AuthenticationHandler constructor.
     * @param RouterInterface $router
     * @param Session $session
     */
    public function __construct(RouterInterface $router, Session $session, Container $container)
    {
        $this->router = $router;
        $this->session = $session;
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return JsonResponse|RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($request->isXmlHttpRequest()) {

            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            return new JsonResponse(array('success' => true, 'message' => 'Vous êtes maintenant Connecté !','username'=>$user->getUsername()));
        } else {
            $url = $this->router->generate('fos_user_profile_show');
            return new RedirectResponse($url);
        }
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse|RedirectResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(array('success' => false, 'message' => 'Identifiants Invalides'));
        } else {
            $request->get('session')->set(Security::AUTHENTICATION_ERROR, $exception);
            return new RedirectResponse($this->router->generate('fos_user_security_login'));
        }
    }
}