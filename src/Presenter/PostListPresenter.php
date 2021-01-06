<?php


namespace App\Presenter;

use App\Responder\PostListResponder;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class PostListPresenter
 * @package App\Presenter
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
