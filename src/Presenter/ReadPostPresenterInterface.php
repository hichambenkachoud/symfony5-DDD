<?php


namespace App\Presenter;

use App\Responder\ReadPostResponder;
use App\Responder\RedirectPostResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface ReadPostPresenterInterface
 * @package App\Presenter
 */
interface ReadPostPresenterInterface
{
    /**
     * @param ReadPostResponder $responder
     * @return Response
     */
    public function present(ReadPostResponder $responder): Response;

    /**
     * @param RedirectPostResponder $responder
     * @return RedirectResponse
     */
    public function redirect(RedirectPostResponder $responder): RedirectResponse;
}
