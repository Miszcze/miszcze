<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Terminarz
 *
 * @ORM\Table(name="terminarz", indexes={@ORM\Index(name="FK_godz_lek_rezerwacje_idx", columns={"godzina"}), @ORM\Index(name="FK_sale_rezerwacje_idx", columns={"sala"}), @ORM\Index(name="FK_terminarz_przedmioty_idx", columns={"kto_co"}), @ORM\Index(name="FK_terminarz_klasy_idx", columns={"klasa"})})
 * @ORM\Entity
 */
class Terminarz
{
    /**
     * @var string
     *
     * @ORM\Column(name="dzien_tygodnia", type="string", length=10, nullable=false)
     */
    private $dzienTygodnia;

    /**
     * @var string
     *
     * @ORM\Column(name="typ", type="string", length=10, nullable=true)
     */
    private $typ;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="poczatek", type="date", nullable=true)
     */
    private $poczatek;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="koniec", type="date", nullable=true)
     */
    private $koniec;

    /**
     * @var string
     *
     * @ORM\Column(name="opis", type="text", length=65535, nullable=true)
     */
    private $opis;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Przedmioty
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Przedmioty")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kto_co", referencedColumnName="id")
     * })
     */
    private $ktoCo;

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
     * @var \AppBundle\Entity\Sale
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sale")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sala", referencedColumnName="id")
     * })
     */
    private $sala;

    /**
     * @var \AppBundle\Entity\GodzLek
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GodzLek")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="godzina", referencedColumnName="id")
     * })
     */
    private $godzina;



    /**
     * Set dzienTygodnia
     *
     * @param string $dzienTygodnia
     *
     * @return Terminarz
     */
    public function setDzienTygodnia($dzienTygodnia)
    {
        $this->dzienTygodnia = $dzienTygodnia;

        return $this;
    }

    /**
     * Get dzienTygodnia
     *
     * @return string
     */
    public function getDzienTygodnia()
    {
        return $this->dzienTygodnia;
    }

    /**
     * Set typ
     *
     * @param string $typ
     *
     * @return Terminarz
     */
    public function setTyp($typ)
    {
        $this->typ = $typ;

        return $this;
    }

    /**
     * Get typ
     *
     * @return string
     */
    public function getTyp()
    {
        return $this->typ;
    }

    /**
     * Set poczatek
     *
     * @param \DateTime $poczatek
     *
     * @return Terminarz
     */
    public function setPoczatek($poczatek)
    {
        $this->poczatek = $poczatek;

        return $this;
    }

    /**
     * Get poczatek
     *
     * @return \DateTime
     */
    public function getPoczatek()
    {
        return $this->poczatek;
    }

    /**
     * Set koniec
     *
     * @param \DateTime $koniec
     *
     * @return Terminarz
     */
    public function setKoniec($koniec)
    {
        $this->koniec = $koniec;

        return $this;
    }

    /**
     * Get koniec
     *
     * @return \DateTime
     */
    public function getKoniec()
    {
        return $this->koniec;
    }

    /**
     * Set opis
     *
     * @param string $opis
     *
     * @return Terminarz
     */
    public function setOpis($opis)
    {
        $this->opis = $opis;

        return $this;
    }

    /**
     * Get opis
     *
     * @return string
     */
    public function getOpis()
    {
        return $this->opis;
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
     * Set ktoCo
     *
     * @param \AppBundle\Entity\Przedmioty $ktoCo
     *
     * @return Terminarz
     */
    public function setKtoCo(\AppBundle\Entity\Przedmioty $ktoCo = null)
    {
        $this->ktoCo = $ktoCo;

        return $this;
    }

    /**
     * Get ktoCo
     *
     * @return \AppBundle\Entity\Przedmioty
     */
    public function getKtoCo()
    {
        return $this->ktoCo;
    }

    /**
     * Set klasa
     *
     * @param \AppBundle\Entity\Klasy $klasa
     *
     * @return Terminarz
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
     * Set sala
     *
     * @param \AppBundle\Entity\Sale $sala
     *
     * @return Terminarz
     */
    public function setSala(\AppBundle\Entity\Sale $sala = null)
    {
        $this->sala = $sala;

        return $this;
    }

    /**
     * Get sala
     *
     * @return \AppBundle\Entity\Sale
     */
    public function getSala()
    {
        return $this->sala;
    }

    /**
     * Set godzina
     *
     * @param \AppBundle\Entity\GodzLek $godzina
     *
     * @return Terminarz
     */
    public function setGodzina(\AppBundle\Entity\GodzLek $godzina = null)
    {
        $this->godzina = $godzina;

        return $this;
    }

    /**
     * Get godzina
     *
     * @return \AppBundle\Entity\GodzLek
     */
    public function getGodzina()
    {
        return $this->godzina;
    }
}
