<?php


namespace App\Presenter;


use App\Responder\CreatePostResponder;
use App\Responder\RedirectPostResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class CreatePostPresenter
 * @package App\Presenter
 */
class CreatePostPresenter implements CreatePostPresenterInterface
{
    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * ReadPostPresenter constructor.
     * @param Environment $twig
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(Environment $twig, UrlGeneratorInterface $urlGenerator)
    {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param CreatePostResponder $responder
     * @return Response
     */
    public function present(CreatePostResponder $responder): Response
    {
        return new Response(
            $this->twig->render('blog/create.html.twig',
                ['form' => $responder->getFormView()]
            )
        );
    }


    /**
     * @param RedirectPostResponder $responder
     * @return RedirectResponse
     */
    public function redirect(RedirectPostResponder $responder): RedirectResponse
    {
        return new RedirectResponse(
            $this->urlGenerator->generate("blog_read", ["id" => $responder->getPost()->getId()])
        );
    }
}
