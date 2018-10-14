<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Uwagi
 *
 * @ORM\Table(name="uwagi", indexes={@ORM\Index(name="FK_uwagi_uczniowie_idx", columns={"uczen"}), @ORM\Index(name="FK_uwagi_pracownicy_idx", columns={"nauczyciel"})})
 * @ORM\Entity
 */
class Uwagi
{
    /**
     * @var string
     *
     * @ORM\Column(name="tresc", type="text", length=65535, nullable=false)
     */
    private $tresc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="odczytane", type="boolean", nullable=true)
     */
    private $odczytane;

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
     * @var \AppBundle\Entity\Uczniowie
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Uczniowie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="uczen", referencedColumnName="id")
     * })
     */
    private $uczen;

    /**
     * @var \AppBundle\Entity\Pracownicy
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pracownicy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nauczyciel", referencedColumnName="id")
     * })
     */
    private $nauczyciel;



    /**
     * Set tresc
     *
     * @param string $tresc
     *
     * @return Uwagi
     */
    public function setTresc($tresc)
    {
        $this->tresc = $tresc;

        return $this;
    }

    /**
     * Get tresc
     *
     * @return string
     */
    public function getTresc()
    {
        return $this->tresc;
    }

    /**
     * Set odczytane
     *
     * @param boolean $odczytane
     *
     * @return Uwagi
     */
    public function setOdczytane($odczytane)
    {
        $this->odczytane = $odczytane;

        return $this;
    }

    /**
     * Get odczytane
     *
     * @return boolean
     */
    public function getOdczytane()
    {
        return $this->odczytane;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Uwagi
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
     * Set uczen
     *
     * @param \AppBundle\Entity\Uczniowie $uczen
     *
     * @return Uwagi
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
     * Set nauczyciel
     *
     * @param \AppBundle\Entity\Pracownicy $nauczyciel
     *
     * @return Uwagi
     */
    public function setNauczyciel(\AppBundle\Entity\Pracownicy $nauczyciel = null)
    {
        $this->nauczyciel = $nauczyciel;

        return $this;
    }

    /**
     * Get nauczyciel
     *
     * @return \AppBundle\Entity\Pracownicy
     */
    public function getNauczyciel()
    {
        return $this->nauczyciel;
    }
}
