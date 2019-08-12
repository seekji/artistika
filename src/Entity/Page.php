<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Sluggable\Sluggable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{
    use Timestampable, Sluggable;

    /**
     * Page templates
     */
    const TEMPLATE_STATIC = 0;
    const TEMPLATE_CONTACTS = 1;
    const TEMPLATE_ABOUT = 2;

    const TEMPLATES = [
        self::TEMPLATE_STATIC => 'static',
        self::TEMPLATE_CONTACTS => 'contacts',
        self::TEMPLATE_ABOUT => 'about',
    ];

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
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="integer")
     */
    private $template = self::TEMPLATE_STATIC;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PageSlides", inversedBy="pages")
     */
    private $slides;

    public function __construct()
    {
        $this->slides = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Page
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Page
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    /**
     * @param bool $isPublished
     * @return Page
     */
    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTemplate(): ?int
    {
        return $this->template;
    }

    /**
     * @param int $template
     * @return Page
     */
    public function setTemplate(int $template): self
    {
        $this->template = $template;

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

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @return Collection|PageSlides[]
     */
    public function getSlides(): Collection
    {
        return $this->slides;
    }

    public function addSlide(PageSlides $slide): self
    {
        if (!$this->slides->contains($slide)) {
            $this->slides[] = $slide;
        }

        return $this;
    }

    public function removeSlide(PageSlides $slide): self
    {
        if ($this->slides->contains($slide)) {
            $this->slides->removeElement($slide);
        }

        return $this;
    }
}
