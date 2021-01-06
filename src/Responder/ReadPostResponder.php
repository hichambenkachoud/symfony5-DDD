<?php


namespace App\Responder;

use App\Entity\Post;
use Symfony\Component\Form\FormView;

/**
 * Class ReadPostResponder
 * @package App\Responder
 */
class ReadPostResponder
{

    /**
     * @var Post
     */
    private Post $post;

    /**
     * @var FormView
     */
    private FormView $formView;

    /**
     * ReadPostResponder constructor.
     * @param Post $post
     * @param FormView $formView
     */
    public function __construct(Post $post, FormView $formView)
    {
        $this->post = $post;
        $this->formView = $formView;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @return FormView
     */
    public function getFormView(): FormView
    {
        return $this->formView;
    }
}
