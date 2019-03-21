<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupConfigRepository")
 */
class GroupConfig
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Config", mappedBy="groupConfig")
     */
    private $configs;

    public function __construct()
    {
        $this->configs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|Config[]
     */
    public function getConfigs(): Collection
    {
        return $this->configs;
    }

    public function addConfig(Config $config): self
    {
        if (!$this->configs->contains($config)) {
            $this->configs[] = $config;
            $config->setGroupConfig($this);
        }

        return $this;
    }

    public function removeConfig(Config $config): self
    {
        if ($this->configs->contains($config)) {
            $this->configs->removeElement($config);
            // set the owning side to null (unless already changed)
            if ($config->getGroupConfig() === $this) {
                $config->setGroupConfig(null);
            }
        }

        return $this;
    }
}
