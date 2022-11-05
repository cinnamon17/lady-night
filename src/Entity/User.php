<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $interests = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $profile_picture = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $profile_picture_second = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $profile_picture_third = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $tokens = null;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Gift::class)]
    private Collection $gifts;

    #[ORM\ManyToMany(targetEntity: Message::class, inversedBy: 'users')]
    private Collection $messages;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function __construct()
    {
        $this->gifts = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getInterests(): ?string
    {
        return $this->interests;
    }

    public function setInterests(?string $interests): self
    {
        $this->interests = $interests;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profile_picture;
    }

    public function setProfilePicture(?string $profile_picture): self
    {
        $this->profile_picture = $profile_picture;

        return $this;
    }

    public function getProfilePictureSecond(): ?string
    {
        return $this->profile_picture_second;
    }

    public function setProfilePictureSecond(?string $profile_picture_second): self
    {
        $this->profile_picture_second = $profile_picture_second;

        return $this;
    }

    public function getProfilePictureThird(): ?string
    {
        return $this->profile_picture_third;
    }

    public function setProfilePictureThird(?string $profile_picture_third): self
    {
        $this->profile_picture_third = $profile_picture_third;

        return $this;
    }

    public function getTokens(): ?string
    {
        return $this->tokens;
    }

    public function setTokens(?string $tokens): self
    {
        $this->tokens = $tokens;

        return $this;
    }

    /**
     * @return Collection<int, Gift>
     */
    public function getGifts(): Collection
    {
        return $this->gifts;
    }

    public function addGift(Gift $gift): self
    {
        if (!$this->gifts->contains($gift)) {
            $this->gifts->add($gift);
            $gift->setUsers($this);
        }

        return $this;
    }

    public function removeGift(Gift $gift): self
    {
        if ($this->gifts->removeElement($gift)) {
            // set the owning side to null (unless already changed)
            if ($gift->getUsers() === $this) {
                $gift->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        $this->messages->removeElement($message);

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

}
