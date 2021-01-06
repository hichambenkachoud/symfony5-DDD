<?php


namespace App\Domain\Blog\Controller;

use App\Application\Repository\PostRepository;
use App\Domain\Blog\Presenter\PostListPresenterInterface;
use App\Domain\Blog\Responder\PostListResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Listing
 * @package App\Domain\Blog\Controller
 */
class Listing
{

    /**
     * @param Request $request
     * @param PostRepository $postRepository
     * @param PostListPresenterInterface $presenter
     * @return Response
     */
    public function __invoke(
        Request $request,
        PostRepository $postRepository,
        PostListPresenterInterface $presenter
    ): Response
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $posts = $postRepository->getPaginatedPosts(
            $page,
            $limit
        );

        $pages = ceil($posts->count() / $limit);

        $range = range(
            max($page - 3, 1),
            min($page + 3, $pages)
        );

        return $presenter->present(new PostListResponder($posts, $pages, $page, $limit, $range));
    }
}
