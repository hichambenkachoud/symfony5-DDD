<?php


namespace App\Controller;

use App\Entity\User;
use App\Handler\RegistrationHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
     * @param EntityManagerInterface $entityManager
     * @param RegistrationHandler $registrationHandler
     * @param UrlGeneratorInterface $generator
     * @param Environment $twig
     * @return RedirectResponse|Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        RegistrationHandler $registrationHandler,
        UrlGeneratorInterface $generator,
        Environment $twig
    )
    {
        if ($registrationHandler->handle($request, new User())) {
            return new RedirectResponse($generator->generate('security_login'));
        }

        return new Response($twig->render("security/registration.html.twig", ['form' => $form->createView()]));
    }
}
