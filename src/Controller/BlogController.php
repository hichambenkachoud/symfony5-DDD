<?php


namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Handler\CommentHandler;
use App\Handler\PostHandler;
use App\Repository\PostRepository;
use App\Security\Voter\PostVoter;
use App\Uploader\UploaderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class BlogController
 * @package App\Controller
 */
class BlogController
{
    use AuthorizationTrait;

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * BlogController constructor.
     * @param Environment $twig
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(Environment $twig, UrlGeneratorInterface $urlGenerator)
    {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }


    /**
     * @Route("/", name="blog_index", methods={"GET"})
     * @param Request $request
     * @param PostRepository $postRepository
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(Request $request, PostRepository $postRepository): Response
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

        return new Response($this->twig->render("blog/index.html.twig", [
            "posts" => $posts,
            "pages" => $pages,
            "page" => $page,
            "limit" => $limit,
            "range" => $range
        ]));
    }

    /**
     * @Route("/article-{id}", name="blog_read", methods={"GET", "POST"})
     * @param Post $post
     * @param Request $request
     * @param CommentHandler $commentHandler
     * @return Response
     */
    public function read(Post $post, Request $request, CommentHandler $commentHandler): Response
    {
        $comment = new Comment();
        $comment->setPost($post);

        $options = [
            'validation_groups' => $this->isGranted('ROLE_USER') ? "Default" : "anonymous"
        ];

        if ($commentHandler->handle($request, $comment, $options))
        {
            return new RedirectResponse($this->urlGenerator->generate('blog_read', ['id' => $post->getId()]));
        }

        return new Response(
            $this->twig->render('read.html.twig', ['post' => $post, 'form' => $commentHandler->createView()])
        );
    }

    /**
     * @Route("/create", name="blog_create", methods={"GET", "POST"})
     * @param Request $request
     * @param PostHandler $postHandler
     * @return Response
     */
    public function create(
        Request $request,
        PostHandler $postHandler
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $post =  new Post();

        if ($postHandler->handle($request, $post, ['validation_groups' => ['Default', 'create']]))
        {
            return new RedirectResponse($this->urlGenerator->generate('blog_read', ['id' => $post->getId()]));
        }

        return new Response(
            $this->twig->render('blog/create.html.twig', ['form' => $postHandler->createView()])
        );
    }

    /**
     * @Route("/update/{id}", name="blog_update", methods={"GET", "POST"})
     * @param Request $request
     * @param Post $post
     * @param PostHandler $postHandler
     * @return Response
     */
    public function update(
        Request $request,
        Post $post,
        PostHandler $postHandler
    ): Response
    {
        $this->denyAccessUnlessGranted(PostVoter::UPDATE, $post);

        if ($postHandler->handle($request, $post))
        {
            return new RedirectResponse($this->urlGenerator->generate('blog_read', ['id' => $post->getId()]));
        }

        return new Response(
            $this->twig->render('blog/update.html.twig', ['form' => $postHandler->createView()])
        );
    }
}
