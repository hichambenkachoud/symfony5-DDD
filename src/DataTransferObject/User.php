<?php


namespace App\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;

use App\Validator\{
    UniquePseudo,
    UniqueEmail
};

/**
 * Class User
 * @package App\DataTransferObject
 */
class User
{

    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Email
     * @UniqueEmail
     */
    private ?string $email;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Length(min=8)
     * @UniquePseudo
     */
    private ?string $pseudo;

    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private ?string $password;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    /**
     * @param string|null $pseudo
     */
    public function setPseudo(?string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

}
