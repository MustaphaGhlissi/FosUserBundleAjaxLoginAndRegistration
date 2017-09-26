<?php
/**
 * Created by PhpStorm.
 * User: ODevS-Inc
 * Date: 9/17/2017
 * Time: 9:52 PM
 */

namespace AuthBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Controller managing the registration.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function registerAction(Request $request)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                if ($request->isXmlHttpRequest()) {
                    $msg = 'Votre compte a été créé, Vous êtes maintenant connecté';
                    $response = new JsonResponse(array('success'=>true,'message'=>$msg,'username'=>$user->getUsername()));
                }

                return $response;
            }
            elseif ($request->isXmlHttpRequest())
            {
                $formErrors = $this->get('validator')->validate($form);
                $ficheErrors = $this->get('validator')->validate($user->getFicheClient());

                $errorsArray=[];
                foreach ($formErrors as $error)
                {
                    $errorsArray[] = array(
                        'elementId' => $error->getPropertyPath(),
                        'errorMessage' => $error->getMessage(),
                    );
                }

                foreach ($ficheErrors as $error)
                {
                    $errorsArray[] = array(
                        'elementId' => $error->getPropertyPath(),
                        'errorMessage' => $error->getMessage(),
                    );
                }
                $msg = "Veuillez renseigner tous les champs";

                return new JsonResponse(['success'=> 'false', 'message' => $msg, 'errors'=>$errorsArray]);
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('@FOSUser/Registration/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}