<?php


namespace App\Domain\User\Controller;

use App\Application\Entity\User;
use App\Domain\User\Handler\RegistrationHandler;
use App\Domain\User\Presenter\RegistrationPresenterInterface;
use App\Domain\User\Responder\RegistrationResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class Registration
 * @package App\Domain\User\Controller
 */
class Registration
{

    /**
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
