<?php


namespace App\Domain\User\Presenter;

use App\Domain\User\Responder\RegistrationResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class LoginPresenter
 * @package App\Presenter
 */
class RegistrationPresenter implements RegistrationPresenterInterface
{

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $generator;

    /**
     * @required
     * @param Environment $twig
     */
    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }

    /**
     * @required
     * @param UrlGeneratorInterface $generator
     */
    public function setGenerator(UrlGeneratorInterface $generator): void
    {
        $this->generator = $generator;
    }


    /**
     * @param RegistrationResponder $responder
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function present(RegistrationResponder $responder): Response
    {
        return new Response($this->twig->render('security/registration.html.twig',
            ['form' => $responder->getFormView()])
        );
    }

    /**
     * @return RedirectResponse
     */
    public function redirect(): RedirectResponse
    {
        return new RedirectResponse($this->generator->generate('security_login'));
    }
}
