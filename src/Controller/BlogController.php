<?php


namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Security\Voter\PostVoter;
use App\Uploader\UploaderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class BlogController
 * @package App\Controller
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog_index", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $posts = $this->getDoctrine()->getRepository(Post::class)->getPaginatedPosts(
            $page,
            $limit
        );

        $pages = ceil($posts->count() / $limit);

        $range = range(
            max($page - 3, 1),
            min($page + 3, $pages)
        );

        return $this->render("blog/index.html.twig", [
            "posts" => $posts,
            "pages" => $pages,
            "page" => $page,
            "limit" => $limit,
            "range" => $range
        ]);
    }

    /**
     * @Route("/article-{id}", name="blog_read", methods={"GET", "POST"})
     * @param Post $post
     * @param Request $request
     * @return Response
     */
    public function read(Post $post, Request $request): Response
    {
        $comment = new Comment();
        $comment->setPost($post);
        if ($this->isGranted('ROLE_USER')) {
            $comment->setUser($this->getUser());
        }
        $form = $this->createForm(CommentType::class, $comment, [
            'validation_groups' => $this->isGranted('ROLE_USER') ? "Default" : "anonymous"
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_read', ['id' => $post->getId()]);
        }

        return $this->render('read.html.twig', ['post' => $post, 'form' => $form->createView()]);
    }

    /**
     * @Route("/create", name="blog_create", methods={"GET", "POST"})
     * @param Request $request
     * @param UploaderInterface $uploader
     * @return Response
     */
    public function create(
        Request $request,
        UploaderInterface $uploader
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $post =  new Post();
        $form = $this->createForm(PostType::class, $post, [
            'validation_groups' => ['Default', 'create']
        ])->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var UploadedFile $file */
            $file = $form->get("file")->getData();
            $fileName = $uploader->upload($file);

            $post->setImage($fileName);
            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_read', ['id' => $post->getId()]);
        }

        return $this->render('blog/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/update/{id}", name="blog_update", methods={"GET", "POST"})
     * @param Request $request
     * @param Post $post
     * @param UploaderInterface $uploader
     * @return Response
     */
    public function update(
        Request $request,
        Post $post,
        UploaderInterface $uploader
    ): Response
    {

        $this->denyAccessUnlessGranted(PostVoter::UPDATE, $post);


        $form = $this->createForm(PostType::class, $post)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var UploadedFile $file */
            $file = $form->get("file")->getData();
            if ($file !== null)
            {
                $fileName = $uploader->upload($file);
                $post->setImage($fileName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_read', ['id' => $post->getId()]);
        }

        return $this->render('blog/update.html.twig', ['form' => $form->createView()]);
    }
}
