<?php


namespace App\Domain\Security\Presenter;

use App\Domain\Security\Responder\LoginResponder;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class LoginPresenter
 * @package App\Presenter
 */
class LoginPresenter implements LoginPresenterInterface
{

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @required
     * @param Environment $twig
     */
    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }

    /**
     * @param LoginResponder $responder
     * @return Response
     */
    public function present(LoginResponder $responder): Response
    {
        return new Response($this->twig->render('security/login.html.twig',
            ['form' => $responder->getFormView()])
        );
    }
}
