<?php


namespace App\Domain\Blog\Presenter;

use App\Domain\Blog\Responder\CreatePostResponder;
use App\Domain\Blog\Responder\RedirectPostResponder;
use App\Domain\Blog\Responder\UpdatePostResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface UpdatePostPresenterInterface
 * @package App\Domain\Blog\Presenter
 */
interface UpdatePostPresenterInterface
{

    /**
     * @param UpdatePostResponder $responder
     * @return Response
     */
    public function present(UpdatePostResponder $responder): Response;

    /**
     * @param RedirectPostResponder $responder
     * @return RedirectResponse
     */
    public function redirect(RedirectPostResponder $responder): RedirectResponse;
}
