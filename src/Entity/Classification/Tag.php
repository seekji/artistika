<?php

namespace App\Entity\Classification;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Sluggable\Sluggable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Classification\TagRepository")
 * @UniqueEntity("slug", message="slug.not_unique")
 */
class Tag
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

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->title;
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
}
