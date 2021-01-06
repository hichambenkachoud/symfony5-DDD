<?php


namespace App\Domain\User\Presenter;

use App\Domain\User\Responder\RegistrationResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface RegistrationPresenterInterface
 * @package App\Presenter
 */
interface RegistrationPresenterInterface
{
    /**
     * @param RegistrationResponder $responder
     * @return Response
     */
     public function present(RegistrationResponder $responder): Response;

    /**
     * @return RedirectResponse
     */
     public function redirect(): RedirectResponse;
}
