<?php


namespace App\Presenter;

use App\Responder\LoginResponder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface LoginPresenterInterface
 * @package App\Presenter
 */
interface LoginPresenterInterface
{
    /**
     * @param LoginResponder $responder
     * @return Response
     */
     public function present(LoginResponder $responder): Response;
}
