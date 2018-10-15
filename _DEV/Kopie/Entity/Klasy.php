<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Klasy
 *
 * @ORM\Table(name="klasy", indexes={@ORM\Index(name="FK_KlasyUczniow_pracownicy_idx", columns={"wychowawca"})})
 * @ORM\Entity
 */
class Klasy
{
    /**
     * @var integer
     *
     * @ORM\Column(name="poziom", type="integer", nullable=false)
     */
    private $poziom;

    /**
     * @var string
     *
     * @ORM\Column(name="klasa", type="string", length=1, nullable=true)
     */
    private $klasa;

    /**
     * @var string
     *
     * @ORM\Column(name="rocznik", type="string", length=4, nullable=false)
     */
    private $rocznik;

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
     * @var \AppBundle\Entity\Pracownicy
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pracownicy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="wychowawca", referencedColumnName="id")
     * })
     */
    private $wychowawca;



    /**
     * Set poziom
     *
     * @param integer $poziom
     *
     * @return Klasy
     */
    public function setPoziom($poziom)
    {
        $this->poziom = $poziom;

        return $this;
    }

    /**
     * Get poziom
     *
     * @return integer
     */
    public function getPoziom()
    {
        return $this->poziom;
    }

    /**
     * Set klasa
     *
     * @param string $klasa
     *
     * @return Klasy
     */
    public function setKlasa($klasa)
    {
        $this->klasa = $klasa;

        return $this;
    }

    /**
     * Get klasa
     *
     * @return string
     */
    public function getKlasa()
    {
        return $this->klasa;
    }

    /**
     * Set rocznik
     *
     * @param string $rocznik
     *
     * @return Klasy
     */
    public function setRocznik($rocznik)
    {
        $this->rocznik = $rocznik;

        return $this;
    }

    /**
     * Get rocznik
     *
     * @return string
     */
    public function getRocznik()
    {
        return $this->rocznik;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Klasy
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
     * Set wychowawca
     *
     * @param \AppBundle\Entity\Pracownicy $wychowawca
     *
     * @return Klasy
     */
    public function setWychowawca(\AppBundle\Entity\Pracownicy $wychowawca = null)
    {
        $this->wychowawca = $wychowawca;

        return $this;
    }

    /**
     * Get wychowawca
     *
     * @return \AppBundle\Entity\Pracownicy
     */
    public function getWychowawca()
    {
        return $this->wychowawca;
    }
}
