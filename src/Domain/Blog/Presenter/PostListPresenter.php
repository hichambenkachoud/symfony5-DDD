<?php


namespace App\Domain\Blog\Presenter;

use App\Domain\Blog\Responder\PostListResponder;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class PostListPresenter
 * @package App\Domain\Blog\Presenter
 */
class PostListPresenter implements PostListPresenterInterface
{
    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * PostListPresenter constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param PostListResponder $responder
     * @return Response
     */
    public function present(PostListResponder $responder): Response
    {
        return new Response($this->twig->render("blog/index.html.twig", [
            "posts" => $responder->getPosts(),
            "pages" => $responder->getPages(),
            "page" => $responder->getPage(),
            "limit" => $responder->getLimit(),
            "range" => $responder->getRange()
        ]));
    }
}
