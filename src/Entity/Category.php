<?php

namespace App\Entity;

use App\Service\UrlService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BlogPost", mappedBy="category")
     */
    private $BlogPost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="categories")
     */
    private $language;

    public function __construct()
    {
        $this->BlogPost = new ArrayCollection();
    }

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|BlogPost[]
     */
    public function getBlogPost(): Collection
    {
        return $this->BlogPost;
    }

    public function addBlogPost(BlogPost $blogPost): self
    {
        if (!$this->BlogPost->contains($blogPost)) {
            $this->BlogPost[] = $blogPost;
            $blogPost->setCategory($this);
        }

        return $this;
    }

    public function removeBlogPost(BlogPost $blogPost): self
    {
        if ($this->BlogPost->contains($blogPost)) {
            $this->BlogPost->removeElement($blogPost);
            // set the owning side to null (unless already changed)
            if ($blogPost->getCategory() === $this) {
                $blogPost->setCategory(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $slug = UrlService::slug($slug);
        $this->slug = $slug;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

}