<?php

namespace App\Entity;

use App\Repository\AttemptRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AttemptRepository::class)
 */
class Attempt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="attempts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $attemptedBy;

    /**
     * @ORM\ManyToOne(targetEntity=Challenge::class, inversedBy="attempts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $challenge;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $attempt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $attemptedOn;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttemptedBy(): ?User
    {
        return $this->attemptedBy;
    }

    public function setAttemptedBy(?User $attemptedBy): self
    {
        $this->attemptedBy = $attemptedBy;

        return $this;
    }

    public function getChallenge(): ?Challenge
    {
        return $this->challenge;
    }

    public function setChallenge(?Challenge $challenge): self
    {
        $this->challenge = $challenge;

        return $this;
    }

    public function getAttempt(): ?string
    {
        return $this->attempt;
    }

    public function setAttempt(string $attempt): self
    {
        $this->attempt = $attempt;

        return $this;
    }

    public function getAttemptedOn(): ?\DateTimeInterface
    {
        return $this->attemptedOn;
    }

    public function setAttemptedOn(\DateTimeInterface $attemptedOn): self
    {
        $this->attemptedOn = $attemptedOn;

        return $this;
    }
}
