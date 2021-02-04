<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

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

    private $killers;

    public function __construct()
    {
        $this->killers = new ArrayCollection();
    }
        /**
     * @return Collection|Killer[]
     */
    public function getKillers(): Collection
    {
        return $this->killers;
    }
        /**
    * param Killer $killer
    * @return Country
    */
    public function addKiller(Killer $killer): self
    {
        if (!$this->killers->contains($killer)) {
            $this->killers[] = $killer;
            $killer->setCountry($this);
        }

        return $this;
    }
         /**
     * @param Killer $killer
     * @return Country
     */

    public function removeKiller(Killer $killer): self
    {
        if ($this->killers->contains($killer)) {
                  $this->killers->removeElement($killer);
                  // set the owning side to null (unless already changed)
                  if ($killer->getCountry() === $this) {
                      $killer->setCountry(null);
                  }
         }

         return $this;
    }   
}
