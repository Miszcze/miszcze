<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ocenianie
 *
 * @ORM\Table(name="ocenianie", indexes={@ORM\Index(name="FK_ocenianie_uczniowie_idx", columns={"uczen"}), @ORM\Index(name="FK_ocenianie_przedmioty_idx", columns={"przedmiot"})})
 * @ORM\Entity
 */
class Ocenianie
{
    /**
     * @var string
     *
     * @ORM\Column(name="semestr", type="string", length=10, nullable=true)
     */
    private $semestr;

    /**
     * @var integer
     *
     * @ORM\Column(name="terminowosc", type="integer", nullable=false)
     */
    private $terminowosc = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="wiedza", type="integer", nullable=false)
     */
    private $wiedza = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="kulturalnosc", type="integer", nullable=false)
     */
    private $kulturalnosc = '0';

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
     * @var \AppBundle\Entity\Przedmioty
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Przedmioty")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="przedmiot", referencedColumnName="id")
     * })
     */
    private $przedmiot;



    /**
     * Set semestr
     *
     * @param string $semestr
     *
     * @return Ocenianie
     */
    public function setSemestr($semestr)
    {
        $this->semestr = $semestr;

        return $this;
    }

    /**
     * Get semestr
     *
     * @return string
     */
    public function getSemestr()
    {
        return $this->semestr;
    }

    /**
     * Set terminowosc
     *
     * @param integer $terminowosc
     *
     * @return Ocenianie
     */
    public function setTerminowosc($terminowosc)
    {
        $this->terminowosc = $terminowosc;

        return $this;
    }

    /**
     * Get terminowosc
     *
     * @return integer
     */
    public function getTerminowosc()
    {
        return $this->terminowosc;
    }

    /**
     * Set wiedza
     *
     * @param integer $wiedza
     *
     * @return Ocenianie
     */
    public function setWiedza($wiedza)
    {
        $this->wiedza = $wiedza;

        return $this;
    }

    /**
     * Get wiedza
     *
     * @return integer
     */
    public function getWiedza()
    {
        return $this->wiedza;
    }

    /**
     * Set kulturalnosc
     *
     * @param integer $kulturalnosc
     *
     * @return Ocenianie
     */
    public function setKulturalnosc($kulturalnosc)
    {
        $this->kulturalnosc = $kulturalnosc;

        return $this;
    }

    /**
     * Get kulturalnosc
     *
     * @return integer
     */
    public function getKulturalnosc()
    {
        return $this->kulturalnosc;
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
     * Set przedmiot
     *
     * @param \AppBundle\Entity\Przedmioty $przedmiot
     *
     * @return Ocenianie
     */
    public function setPrzedmiot(\AppBundle\Entity\Przedmioty $przedmiot = null)
    {
        $this->przedmiot = $przedmiot;

        return $this;
    }

    /**
     * Get przedmiot
     *
     * @return \AppBundle\Entity\Przedmioty
     */
    public function getPrzedmiot()
    {
        return $this->przedmiot;
    }
}
