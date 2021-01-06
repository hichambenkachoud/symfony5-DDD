<?php


namespace App\Domain\Blog\Controller;

use App\Application\Entity\Post;
use App\Domain\Blog\Handler\PostHandler;
use App\Domain\Blog\Presenter\CreatePostPresenterInterface;
use App\Domain\Blog\Responder\CreatePostResponder;
use App\Domain\Blog\Responder\RedirectPostResponder;
use App\Infrastructure\Controller\AuthorizationTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Create
 * @package App\Domain\Blog\Controller
 */
class Create
{
    use AuthorizationTrait;

    /**
     * @param Request $request
     * @param PostHandler $postHandler
     * @param CreatePostPresenterInterface $presenter
     * @return Response
     */
    public function __invoke(
        Request $request,
        PostHandler $postHandler,
        CreatePostPresenterInterface $presenter
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $post =  new Post();

        if ($postHandler->handle($request, $post, ['validation_groups' => ['Default', 'create']]))
        {
            return $presenter->redirect(new RedirectPostResponder($post));
        }

        return $presenter->present(new CreatePostResponder($postHandler->createView()));
    }
}
