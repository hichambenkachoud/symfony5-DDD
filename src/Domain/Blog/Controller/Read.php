<?php


namespace App\Domain\Blog\Controller;

use App\Application\Entity\Comment;
use App\Application\Entity\Post;
use App\Domain\Blog\Handler\CommentHandler;
use App\Domain\Blog\Presenter\ReadPostPresenterInterface;
use App\Domain\Blog\Responder\ReadPostResponder;
use App\Domain\Blog\Responder\RedirectPostResponder;
use App\Infrastructure\Controller\AuthorizationTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Read
 * @package App\Domain\Blog\Controller
 */
class Read
{
    use AuthorizationTrait;

    /**
     * @param Post $post
     * @param Request $request
     * @param CommentHandler $commentHandler
     * @param ReadPostPresenterInterface $presenter
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(
        Post $post,
        Request $request,
        CommentHandler $commentHandler,
        ReadPostPresenterInterface $presenter
    ): Response
    {
        $comment = new Comment();
        $comment->setPost($post);

        $options = [
            'validation_groups' => $this->isGranted('ROLE_USER') ? "Default" : "anonymous"
        ];

        if ($commentHandler->handle($request, $comment, $options))
        {
            return $presenter->redirect(new RedirectPostResponder($post));
        }

        return $presenter->present(new ReadPostResponder($post, $commentHandler->createView()));
    }

}
