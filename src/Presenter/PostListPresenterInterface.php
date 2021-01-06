<?php


namespace App\Presenter;

use App\Responder\PostListResponder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface PostListPresenterInterface
 * @package App\Presenter
 */
interface PostListPresenterInterface
{
    /**
     * @param PostListResponder $responder
     * @return Response
     */
    public function present(PostListResponder $responder): Response;
}
