<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Handler\RegistrationHandler;
use App\Presenter\RegistrationPresenterInterface;
use App\Responder\RegistrationResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController
{
    /**
     * @Route("/register", name="registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param FormFactoryInterface $formFactory
     * @param RegistrationHandler $registrationHandler
     * @param UrlGeneratorInterface $generator
     * @param RegistrationPresenterInterface $presenter
     * @return RedirectResponse|Response
     */
    public function __invoke(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        FormFactoryInterface $formFactory,
        RegistrationHandler $registrationHandler,
        UrlGeneratorInterface $generator,
        RegistrationPresenterInterface $presenter
    )
    {
        if ($registrationHandler->handle($request, new User())) {
            return $presenter->redirect();
        }

        return $presenter->present(new RegistrationResponder($registrationHandler->createView()));
    }
}
