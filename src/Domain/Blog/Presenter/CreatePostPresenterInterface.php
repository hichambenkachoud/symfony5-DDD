<?php


namespace App\Domain\Blog\Presenter;


use App\Domain\Blog\Responder\CreatePostResponder;
use App\Domain\Blog\Responder\RedirectPostResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface CreatePostPresenterInterface
 * @package App\Domain\Blog\Presenter
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
