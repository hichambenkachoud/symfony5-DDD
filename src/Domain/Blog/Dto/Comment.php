<?php


namespace App\Domain\Blog\Dto;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment
 * @package App\DataTransferObject
 */
class Comment
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank(groups={"anonymous"})
     * @Assert\Length(min=5, groups={"anonymous"})
     */
    private ?string $author;

    /**
     * @var string|null
     *
     * @Assert\NotBlank
     * @Assert\Length(min=10)
     */
    private ?string $content;

    /**
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string|null $author
     */
    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string|null
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


}
