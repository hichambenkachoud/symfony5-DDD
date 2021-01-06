<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class UniquePseudo
 * @package App\Validator
 * @Annotation
 */
class UniquePseudo extends Constraint
{
    /**
     * @var string
     */
    public string $message = "This Pseudo Already Exist";
}
