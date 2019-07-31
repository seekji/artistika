<?php

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Sluggable\Sluggable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 */
class News
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
     * @ORM\Column(type="text")
     */
    private $description;

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
     * @ORM\Column(type="boolean")
     */
    private $isPublished = false;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}
