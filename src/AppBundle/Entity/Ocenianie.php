<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ocenianie
 *
 * @ORM\Table(name="ocenianie", indexes={@ORM\Index(name="FK_ocenianie_uczniowie_idx", columns={"uczen"}), @ORM\Index(name="FK_ocenianie_pracownicy_idx", columns={"prowadzacy"})})
 * @ORM\Entity
 */
class Ocenianie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="ocena", type="integer", nullable=false)
     */
    private $ocena = '0';

    /**
     * @var \AppBundle\Entity\Uczniowie
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Uczniowie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="uczen", referencedColumnName="id")
     * })
     */
    private $uczen;

    /**
     * @var \AppBundle\Entity\Przedmioty
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pracownicy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prowadzacy", referencedColumnName="id")
     * })
     */
    private $prowadzacy;

    /**
     * Set terminowosc
     *
     * @param integer $terminowosc
     *
     * @return Ocenianie
     */
    public function setOcena($ocena)
    {
        $this->ocena = $ocena;

        return $this;
    }

    /**
     * Get terminowosc
     *
     * @return integer
     */
    public function getOcena()
    {
        return $this->ocena;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set uczen
     *
     * @param \AppBundle\Entity\Uczniowie $uczen
     *
     * @return Ocenianie
     */
    public function setUczen(\AppBundle\Entity\Uczniowie $uczen = null)
    {
        $this->uczen = $uczen;

        return $this;
    }

    /**
     * Get uczen
     *
     * @return \AppBundle\Entity\Uczniowie
     */
    public function getUczen()
    {
        return $this->uczen;
    }

    /**
     * Set terminowosc
     *
     * @param integer $terminowosc
     *
     * @return Ocenianie
     */
    public function setProwadzacy($prowadzacy)
    {
        $this->prowadzacy = $prowadzacy;

        return $this;
    }

    /**
     * Get terminowosc
     *
     * @return integer
     */
    public function getProwadzacy()
    {
        return $this->prowadzacy;
    }
}
