<?php


namespace App\Domain\Security\Responder;

use Symfony\Component\Form\FormView;

/**
 * Class LoginResponder
 * @package App\Responder
 */
class LoginResponder
{
    /**
     * @var FormView
     */
    private FormView $formView;

    /**
     * LoginResponder constructor.
     * @param FormView $formView
     */
    public function __construct(FormView $formView)
    {
        $this->formView = $formView;
    }

    /**
     * @return FormView
     */
    public function getFormView(): FormView
    {
        return $this->formView;
    }

}
