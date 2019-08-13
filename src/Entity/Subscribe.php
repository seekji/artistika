<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use App\Entity\Handbook\City;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscribeRepository")
 * @UniqueEntity("email", message="email.not_unique")
 */
class Subscribe
{
    use Timestampable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Email(groups={"user_creation"}, message="email.email")
     * @Assert\NotBlank(groups={"user_creation"}, message="email.not_blank")
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Handbook\City")
     * @ORM\JoinColumn(nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mailchimpId;

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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getMailchimpId(): ?string
    {
        return $this->mailchimpId;
    }

    public function setMailchimpId(?string $mailchimpId): self
    {
        $this->mailchimpId = $mailchimpId;

        return $this;
    }
}
