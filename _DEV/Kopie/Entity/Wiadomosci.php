<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wiadomosci
 *
 * @ORM\Table(name="wiadomosci", indexes={@ORM\Index(name="FK_wiadomosci_uzytkownicy_nadawca_idx", columns={"nadawca"}), @ORM\Index(name="FK_wiadomosci_uzytkownicy_odbiorca_idx", columns={"odbiorca"})})
 * @ORM\Entity
 */
class Wiadomosci
{
    /**
     * @var string
     *
     * @ORM\Column(name="tytul", type="string", length=100, nullable=true)
     */
    private $tytul;

    /**
     * @var string
     *
     * @ORM\Column(name="tresc", type="text", length=65535, nullable=false)
     */
    private $tresc;

    /**
     * @var string
     *
     * @ORM\Column(name="zalacznik", type="string", length=45, nullable=true)
     */
    private $zalacznik;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status_nadawcy", type="boolean", nullable=true)
     */
    private $statusNadawcy;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status_odbiorcy", type="boolean", nullable=true)
     */
    private $statusOdbiorcy;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="odczytana", type="boolean")
     */
    private $odczytana;

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
     *   @ORM\JoinColumn(name="odbiorca", referencedColumnName="id")
     * })
     */
    private $odbiorca;

    /**
     * @var \AppBundle\Entity\Uzytkownicy
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Uzytkownicy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nadawca", referencedColumnName="id")
     * })
     */
    private $nadawca;



    /**
     * Set tytul
     *
     * @param string $tytul
     *
     * @return Wiadomosci
     */
    public function setTytul($tytul)
    {
        $this->tytul = $tytul;

        return $this;
    }

    /**
     * Get tytul
     *
     * @return string
     */
    public function getTytul()
    {
        return $this->tytul;
    }

    /**
     * Set tresc
     *
     * @param string $tresc
     *
     * @return Wiadomosci
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
     * Set zalacznik
     *
     * @param string $zalacznik
     *
     * @return Wiadomosci
     */
    public function setZalacznik($zalacznik)
    {
        $this->zalacznik = $zalacznik;

        return $this;
    }

    /**
     * Get zalacznik
     *
     * @return string
     */
    public function getZalacznik()
    {
        return $this->zalacznik;
    }

    /**
     * Set statusNadawcy
     *
     * @param boolean $statusNadawcy
     *
     * @return Wiadomosci
     */
    public function setStatusNadawcy($statusNadawcy)
    {
        $this->statusNadawcy = $statusNadawcy;

        return $this;
    }

    /**
     * Get statusNadawcy
     *
     * @return boolean
     */
    public function getStatusNadawcy()
    {
        return $this->statusNadawcy;
    }

    /**
     * Set statusOdbiorcy
     *
     * @param boolean $statusOdbiorcy
     *
     * @return Wiadomosci
     */
    public function setStatusOdbiorcy($statusOdbiorcy)
    {
        $this->statusOdbiorcy = $statusOdbiorcy;

        return $this;
    }

    /**
     * Get statusOdbiorcy
     *
     * @return boolean
     */
    public function getStatusOdbiorcy()
    {
        return $this->statusOdbiorcy;
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
     * Set odbiorca
     *
     * @param \AppBundle\Entity\Uzytkownicy $odbiorca
     *
     * @return Wiadomosci
     */
    public function setOdbiorca(\AppBundle\Entity\Uzytkownicy $odbiorca = null)
    {
        $this->odbiorca = $odbiorca;

        return $this;
    }

    /**
     * Get odbiorca
     *
     * @return \AppBundle\Entity\Uzytkownicy
     */
    public function getOdbiorca()
    {
        return $this->odbiorca;
    }

    /**
     * Set nadawca
     *
     * @param \AppBundle\Entity\Uzytkownicy $nadawca
     *
     * @return Wiadomosci
     */
    public function setNadawca(\AppBundle\Entity\Uzytkownicy $nadawca = null)
    {
        $this->nadawca = $nadawca;

        return $this;
    }

    /**
     * Get nadawca
     *
     * @return \AppBundle\Entity\Uzytkownicy
     */
    public function getNadawca()
    {
        return $this->nadawca;
    }
    
    public function setOdczytana($odczytana)
    {
        $this->odczytana = $odczytana;

        return $this;
    }

    public function getOdczytana()
    {
        return $this->odczytana;
    }
}
