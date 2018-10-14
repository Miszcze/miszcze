<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Przedmioty
 *
 * @ORM\Table(name="przedmioty", indexes={@ORM\Index(name="FK_pracownicy_przedmioty_idx", columns={"prowadzacy"}), @ORM\Index(name="FK_przedmioty_[pracownicy_idx", columns={"przedmiot"})})
 * @ORM\Entity
 */
class Przedmioty
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\SlownikPrzedmiotow
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SlownikPrzedmiotow")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="przedmiot", referencedColumnName="id")
     * })
     */
    private $przedmiot;

    /**
     * @var \AppBundle\Entity\Pracownicy
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pracownicy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prowadzacy", referencedColumnName="id")
     * })
     */
    private $prowadzacy;



    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Przedmioty
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
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
     * Set przedmiot
     *
     * @param \AppBundle\Entity\SlownikPrzedmiotow $przedmiot
     *
     * @return Przedmioty
     */
    public function setPrzedmiot(\AppBundle\Entity\SlownikPrzedmiotow $przedmiot = null)
    {
        $this->przedmiot = $przedmiot;

        return $this;
    }

    /**
     * Get przedmiot
     *
     * @return \AppBundle\Entity\SlownikPrzedmiotow
     */
    public function getPrzedmiot()
    {
        return $this->przedmiot;
    }

    /**
     * Set prowadzacy
     *
     * @param \AppBundle\Entity\Pracownicy $prowadzacy
     *
     * @return Przedmioty
     */
    public function setProwadzacy(\AppBundle\Entity\Pracownicy $prowadzacy = null)
    {
        $this->prowadzacy = $prowadzacy;

        return $this;
    }

    /**
     * Get prowadzacy
     *
     * @return \AppBundle\Entity\Pracownicy
     */
    public function getProwadzacy()
    {
        return $this->prowadzacy;
    }
}
