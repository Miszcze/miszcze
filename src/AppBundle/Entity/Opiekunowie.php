<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Opiekunowie
 *
 * @ORM\Table(name="opiekunowie", indexes={@ORM\Index(name="FK_opiekunowie_users_idx", columns={"uzytkownik"})})
 * @ORM\Entity
 */
class Opiekunowie
{
    /**
     * @var string
     *
     * @ORM\Column(name="imie", type="string", length=15, nullable=false)
     */
    private $imie;

    /**
     * @var string
     *
     * @ORM\Column(name="nazwisko", type="string", length=30, nullable=false)
     */
    private $nazwisko;

    /**
     * @var string
     *
     * @ORM\Column(name="kontakt", type="text", length=65535, nullable=false)
     */
    private $kontakt;

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
     * @var \AppBundle\Entity\Uzytkownicy
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Uzytkownicy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="uzytkownik", referencedColumnName="id")
     * })
     */
    private $uzytkownik;



    /**
     * Set imie
     *
     * @param string $imie
     *
     * @return Opiekunowie
     */
    public function setImie($imie)
    {
        $this->imie = $imie;

        return $this;
    }

    /**
     * Get imie
     *
     * @return string
     */
    public function getImie()
    {
        return $this->imie;
    }

    /**
     * Set nazwisko
     *
     * @param string $nazwisko
     *
     * @return Opiekunowie
     */
    public function setNazwisko($nazwisko)
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    /**
     * Get nazwisko
     *
     * @return string
     */
    public function getNazwisko()
    {
        return $this->nazwisko;
    }

    /**
     * Set kontakt
     *
     * @param string $kontakt
     *
     * @return Opiekunowie
     */
    public function setKontakt($kontakt)
    {
        $this->kontakt = $kontakt;

        return $this;
    }

    /**
     * Get kontakt
     *
     * @return string
     */
    public function getKontakt()
    {
        return $this->kontakt;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Opiekunowie
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
     * Set uzytkownik
     *
     * @param \AppBundle\Entity\Uzytkownicy $uzytkownik
     *
     * @return Opiekunowie
     */
    public function setUzytkownik(\AppBundle\Entity\Uzytkownicy $uzytkownik = null)
    {
        $this->uzytkownik = $uzytkownik;

        return $this;
    }

    /**
     * Get uzytkownik
     *
     * @return \AppBundle\Entity\Uzytkownicy
     */
    public function getUzytkownik()
    {
        return $this->uzytkownik;
    }
}
