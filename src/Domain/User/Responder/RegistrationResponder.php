<?php


namespace App\Domain\User\Responder;

use Symfony\Component\Form\FormView;

/**
 * Class RegistrationResponder
 * @package App\Responder
 */
class RegistrationResponder
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
