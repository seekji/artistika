<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait SeoTrait
 * @package App\Entity\Traits
 */
trait SeoTrait
{
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $metaTitle;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $metaDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $metaKeywords;

    /**
     * @return null|string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * @param null|string $metaTitle
     * @return $this
     */
    public function setMetaTitle(?string $metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param null|string $metaDescription
     * @return $this
     */
    public function setMetaDescription(?string $metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @param null|string $metaKeywords
     * @return $this
     */
    public function setMetaKeywords(?string $metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

}