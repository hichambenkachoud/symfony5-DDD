<?php


namespace App\Presenter;

use App\Responder\CreatePostResponder;
use App\Responder\RedirectPostResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface CreatePostPresenterInterface
 * @package App\Presenter
 */
interface CreatePostPresenterInterface
{

    /**
     * @param CreatePostResponder $responder
     * @return Response
     */
    public function present(CreatePostResponder $responder): Response;

    /**
     * @param RedirectPostResponder $responder
     * @return RedirectResponse
     */
    public function redirect(RedirectPostResponder $responder): RedirectResponse;
}
