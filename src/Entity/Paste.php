<?php

namespace App\Entity;

use App\Repository\PasteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PasteRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Paste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 50)]
    private ?string $expiration_time = null;

    #[ORM\Column(length: 20)]
    private ?string $access = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(length: 20)]
    private ?string $lang = null;

    #[ORM\ManyToOne(inversedBy: 'pastes')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getExpirationTime(): ?string
    {
        return $this->expiration_time;
    }

    public function setExpirationTime(string $expiration_time): static
    {
        $this->expiration_time = $expiration_time;

        return $this;
    }

    public function getAccess(): ?string
    {
        return $this->access;
    }

    public function setAccess(string $access): static
    {
        $this->access = $access;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(string $lang): static
    {
        $this->lang = $lang;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function setCreatedAt()
    {
        $this->created_at = new \DateTime("now");
    }
}
