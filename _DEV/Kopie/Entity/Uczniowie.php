<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Uczniowie
 *
 * @ORM\Table(name="uczniowie", uniqueConstraints={@ORM\UniqueConstraint(name="pesel_UNIQUE", columns={"pesel"})}, indexes={@ORM\Index(name="opiekun_idx", columns={"opiekun"}), @ORM\Index(name="FK_uczniowe_users_idx", columns={"uzytkownik"}), @ORM\Index(name="FK_uczniowie_klasy_idx", columns={"klasa"})})
 * @ORM\Entity
 */
class Uczniowie
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
     * @ORM\Column(name="imie_2", type="string", length=15, nullable=true)
     */
    private $imie2;

    /**
     * @var string
     *
     * @ORM\Column(name="nazwisko", type="string", length=30, nullable=false)
     */
    private $nazwisko;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_urodzenia", type="date", nullable=false)
     */
    private $dataUrodzenia;

    /**
     * @var string
     *
     * @ORM\Column(name="pesel", type="string", length=11, nullable=false)
     */
    private $pesel;

    /**
     * @var string
     *
     * @ORM\Column(name="miejscowosc", type="string", length=45, nullable=false)
     */
    private $miejscowosc;

    /**
     * @var string
     *
     * @ORM\Column(name="ulica", type="string", length=45, nullable=true)
     */
    private $ulica;

    /**
     * @var string
     *
     * @ORM\Column(name="nr_domu", type="string", length=10, nullable=false)
     */
    private $nrDomu;

    /**
     * @var string
     *
     * @ORM\Column(name="kod_pocztowy", type="string", length=6, nullable=false)
     */
    private $kodPocztowy;

    /**
     * @var string
     *
     * @ORM\Column(name="poczta", type="string", length=45, nullable=false)
     */
    private $poczta;

    /**
     * @var string
     *
     * @ORM\Column(name="kontakt", type="text", length=65535, nullable=true)
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
     * @var \AppBundle\Entity\Opiekunowie
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Opiekunowie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="opiekun", referencedColumnName="id")
     * })
     */
    private $opiekun;

    /**
     * @var \AppBundle\Entity\Klasy
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Klasy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="klasa", referencedColumnName="id")
     * })
     */
    private $klasa;

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
     * @return Uczniowie
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
     * Set imie2
     *
     * @param string $imie2
     *
     * @return Uczniowie
     */
    public function setImie2($imie2)
    {
        $this->imie2 = $imie2;

        return $this;
    }

    /**
     * Get imie2
     *
     * @return string
     */
    public function getImie2()
    {
        return $this->imie2;
    }

    /**
     * Set nazwisko
     *
     * @param string $nazwisko
     *
     * @return Uczniowie
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
     * Set dataUrodzenia
     *
     * @param \DateTime $dataUrodzenia
     *
     * @return Uczniowie
     */
    public function setDataUrodzenia($dataUrodzenia)
    {
        $this->dataUrodzenia = $dataUrodzenia;

        return $this;
    }

    /**
     * Get dataUrodzenia
     *
     * @return \DateTime
     */
    public function getDataUrodzenia()
    {
        return $this->dataUrodzenia;
    }

    /**
     * Set pesel
     *
     * @param string $pesel
     *
     * @return Uczniowie
     */
    public function setPesel($pesel)
    {
        $this->pesel = $pesel;

        return $this;
    }

    /**
     * Get pesel
     *
     * @return string
     */
    public function getPesel()
    {
        return $this->pesel;
    }

    /**
     * Set miejscowosc
     *
     * @param string $miejscowosc
     *
     * @return Uczniowie
     */
    public function setMiejscowosc($miejscowosc)
    {
        $this->miejscowosc = $miejscowosc;

        return $this;
    }

    /**
     * Get miejscowosc
     *
     * @return string
     */
    public function getMiejscowosc()
    {
        return $this->miejscowosc;
    }

    /**
     * Set ulica
     *
     * @param string $ulica
     *
     * @return Uczniowie
     */
    public function setUlica($ulica)
    {
        $this->ulica = $ulica;

        return $this;
    }

    /**
     * Get ulica
     *
     * @return string
     */
    public function getUlica()
    {
        return $this->ulica;
    }

    /**
     * Set nrDomu
     *
     * @param string $nrDomu
     *
     * @return Uczniowie
     */
    public function setNrDomu($nrDomu)
    {
        $this->nrDomu = $nrDomu;

        return $this;
    }

    /**
     * Get nrDomu
     *
     * @return string
     */
    public function getNrDomu()
    {
        return $this->nrDomu;
    }

    /**
     * Set kodPocztowy
     *
     * @param string $kodPocztowy
     *
     * @return Uczniowie
     */
    public function setKodPocztowy($kodPocztowy)
    {
        $this->kodPocztowy = $kodPocztowy;

        return $this;
    }

    /**
     * Get kodPocztowy
     *
     * @return string
     */
    public function getKodPocztowy()
    {
        return $this->kodPocztowy;
    }

    /**
     * Set poczta
     *
     * @param string $poczta
     *
     * @return Uczniowie
     */
    public function setPoczta($poczta)
    {
        $this->poczta = $poczta;

        return $this;
    }

    /**
     * Get poczta
     *
     * @return string
     */
    public function getPoczta()
    {
        return $this->poczta;
    }

    /**
     * Set kontakt
     *
     * @param string $kontakt
     *
     * @return Uczniowie
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
     * @return Uczniowie
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
     * Set opiekun
     *
     * @param \AppBundle\Entity\Opiekunowie $opiekun
     *
     * @return Uczniowie
     */
    public function setOpiekun(\AppBundle\Entity\Opiekunowie $opiekun = null)
    {
        $this->opiekun = $opiekun;

        return $this;
    }

    /**
     * Get opiekun
     *
     * @return \AppBundle\Entity\Opiekunowie
     */
    public function getOpiekun()
    {
        return $this->opiekun;
    }

    /**
     * Set klasa
     *
     * @param \AppBundle\Entity\Klasy $klasa
     *
     * @return Uczniowie
     */
    public function setKlasa(\AppBundle\Entity\Klasy $klasa = null)
    {
        $this->klasa = $klasa;

        return $this;
    }

    /**
     * Get klasa
     *
     * @return \AppBundle\Entity\Klasy
     */
    public function getKlasa()
    {
        return $this->klasa;
    }

    /**
     * Set uzytkownik
     *
     * @param \AppBundle\Entity\Uzytkownicy $uzytkownik
     *
     * @return Uczniowie
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
