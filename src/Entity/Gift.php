<?php

namespace App\Entity;

use App\Repository\GiftRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GiftRepository::class)]
class Gift
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'gifts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $users = null;

    #[ORM\Column(nullable: true)]
    private ?int $hearts = null;

    #[ORM\Column(nullable: true)]
    private ?int $kisses = null;

    #[ORM\Column(nullable: true)]
    private ?int $fires = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getHearts(): ?int
    {
        return $this->hearts;
    }

    public function setHearts(?int $hearts): self
    {
        $this->hearts = $hearts;

        return $this;
    }

    public function getKisses(): ?int
    {
        return $this->kisses;
    }

    public function setKisses(?int $kisses): self
    {
        $this->kisses = $kisses;

        return $this;
    }

    public function getFires(): ?int
    {
        return $this->fires;
    }

    public function setFires(?int $fires): self
    {
        $this->fires = $fires;

        return $this;
    }
}
