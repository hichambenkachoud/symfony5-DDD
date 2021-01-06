<?php


namespace App\Domain\Blog\Presenter;

use App\Domain\Blog\Responder\PostListResponder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface PostListPresenterInterface
 * @package App\Domain\Blog\Presenter
 */
interface PostListPresenterInterface
{
    /**
     * @param PostListResponder $responder
     * @return Response
     */
    public function present(PostListResponder $responder): Response;
}
