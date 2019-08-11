<?php

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Entity\Classification\Tag;
use App\Entity\Handbook\City;
use App\Entity\Handbook\Hall;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Sluggable\Sluggable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"description", "artist"}, flags={"fulltext"})})
 */
class Event
{
    use Timestampable, Sluggable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Handbook\City")
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Handbook\Hall")
     * @Assert\NotBlank()
     */
    private $hall;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Classification\Tag")
     */
    private $tags;

    /**
     * @ORM\Column(type="text")
     */
    private $artist;

    /**
     * @ORM\Column(type="date")
     */
    private $startedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCanceled;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPreviewBig;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Application\Sonata\MediaBundle\Entity\Media",
     *     cascade={"persist", "remove"},
     * )
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $picture;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Application\Sonata\MediaBundle\Entity\Media",
     *     cascade={"persist", "remove"},
     * )
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $detailPicture;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Application\Sonata\MediaBundle\Entity\Media",
     *     cascade={"persist", "remove"},
     * )
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $bigPicture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventSchedule", mappedBy="event", orphanRemoval=true, cascade={"persist"})
     * @Assert\NotBlank()
     */
    private $tickets;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $additionalText;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $socialLinks = [];

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHall(): ?Hall
    {
        return $this->hall;
    }

    public function setHall(?Hall $hall): self
    {
        $this->hall = $hall;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    public function setSlug($slug): self
    {
        $this->slug = self::slugify($slug);

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @static
     *
     * @param string $text
     *
     * @return string
     */
    public static function slugify($text): string
    {
        $text = Slugify::create()->slugify($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * Returns an array of the fields used to generate the slug.
     *
     * @return array
     */
    public function getSluggableFields()
    {
        return ['title'];
    }

    /**
     * Disable slug regeneration in update.
     *
     * @return bool
     */
    public function getRegenerateSlugOnUpdate()
    {
        return false;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getIsCanceled(): ?bool
    {
        return $this->isCanceled;
    }

    public function setIsCanceled(bool $isCanceled): self
    {
        $this->isCanceled = $isCanceled;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIsPreviewBig(): ?bool
    {
        return $this->isPreviewBig;
    }

    public function setIsPreviewBig(bool $isPreviewBig): self
    {
        $this->isPreviewBig = $isPreviewBig;

        return $this;
    }

    /**
     * @return null|Media
     */
    public function getPicture(): ?Media
    {
        return $this->picture;
    }

    /**
     * @param Media $picture
     *
     * @return $this
     */
    public function setPicture(Media $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return null|Media
     */
    public function getDetailPicture(): ?Media
    {
        return $this->detailPicture;
    }

    /**
     * @param Media $detailPicture
     *
     * @return $this
     */
    public function setDetailPicture(Media $detailPicture): self
    {
        $this->detailPicture = $detailPicture;

        return $this;
    }

    /**
     * @return null|Media
     */
    public function getBigPicture(): ?Media
    {
        return $this->bigPicture;
    }

    /**
     * @param Media $bigPicture
     *
     * @return $this
     */
    public function setBigPicture(Media $bigPicture): self
    {
        $this->bigPicture = $bigPicture;

        return $this;
    }

    /**
     * @return Collection|EventSchedule[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(EventSchedule $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setEvent($this);
        }

        return $this;
    }

    public function removeTicket(EventSchedule $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getEvent() === $this) {
                $ticket->setEvent(null);
            }
        }

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getAdditionalText(): ?string
    {
        return $this->additionalText;
    }

    public function setAdditionalText(?string $additionalText): self
    {
        $this->additionalText = $additionalText;

        return $this;
    }

    public function getSocialLinks(): ?array
    {
        return $this->socialLinks;
    }

    public function setSocialLinks(?array $socialLinks): self
    {
        $this->socialLinks = $socialLinks;

        return $this;
    }
}
