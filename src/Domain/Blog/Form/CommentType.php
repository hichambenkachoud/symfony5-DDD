<?php


namespace App\Domain\Blog\Form;

use App\Domain\Blog\Dto\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class CommentType
 * @package App\Form
 */
class CommentType extends AbstractType
{

    /**
     * @var AuthorizationCheckerInterface
     */
    private AuthorizationCheckerInterface $authorizerChecker;

    /**
     * CommentType constructor.
     * @param AuthorizationCheckerInterface $authorizerChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizerChecker)
    {
        $this->authorizerChecker = $authorizerChecker;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Your message'
            ]);

        if (!$this->authorizerChecker->isGranted('ROLE_USER'))
        {
            $builder->add('author', TextType::class, [
                'label' => 'Author',
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ]);
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // pour hydrater notre objet sans passer par le constructeur
        $resolver->setDefault('data_class', Comment::class);
    }
}
