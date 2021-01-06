<?php


namespace App\Domain\Blog\Dto;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Post
 * @package App\DataTransferObject
 */
class Post
{

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(min=5)
     */
    private ?string $title;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(min=10)
     */
    private ?string $content;

    /**
     * @var UploadedFile|null
     * @Assert\NotNull(groups={"create"})
     * @Assert\Image
     */
    private ?UploadedFile $image;

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return UploadedFile|null
     */
    public function getImage(): ?UploadedFile
    {
        return $this->image;
    }

    /**
     * @param UploadedFile|null $image
     */
    public function setImage(?UploadedFile $image): void
    {
        $this->image = $image;
    }
}
