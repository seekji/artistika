<?php

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageSlidesRepository")
 */
class PageSlides
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
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $smallText;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event")
     */
    private $event;

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
     * @ORM\ManyToMany(targetEntity="App\Entity\Page", mappedBy="slides")
     */
    private $pages;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getSmallText(): ?string
    {
        return $this->smallText;
    }

    public function setSmallText(?string $smallText): self
    {
        $this->smallText = $smallText;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

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

    public function __toString()
    {
        return $this->getText();
    }

    /**
     * @return Collection|Page[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->addSlide($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->contains($page)) {
            $this->pages->removeElement($page);
            $page->removeSlide($this);
        }

        return $this;
    }
}
