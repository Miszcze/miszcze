<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oceny
 *
 * @ORM\Table(name="oceny", indexes={@ORM\Index(name="fk_uczniowe_has_pracownik_na_przedmiot_pracownik_na_przedmi_idx", columns={"przedmiot"}), @ORM\Index(name="fk_uczniowe_has_pracownik_na_przedmiot_uczniowe1_idx", columns={"uczen"})})
 * @ORM\Entity
 */
class Oceny
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ocena", type="integer", nullable=false)
     */
    private $ocena;

    /**
     * @var integer
     *
     * @ORM\Column(name="waga", type="integer", nullable=true)
     */
    private $waga;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="kiedy", type="datetime", nullable=false)
     */
    private $kiedy;

    /**
     * @var string
     *
     * @ORM\Column(name="typ", type="string", length=10, nullable=false)
     */
    private $typ;

    /**
     * @var string
     *
     * @ORM\Column(name="uwagi", type="text", length=65535, nullable=true)
     */
    private $uwagi;

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
     * @var \AppBundle\Entity\Przedmioty
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Przedmioty")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="przedmiot", referencedColumnName="id")
     * })
     */
    private $przedmiot;



    /**
     * Set ocena
     *
     * @param integer $ocena
     *
     * @return Oceny
     */
    public function setOcena($ocena)
    {
        $this->ocena = $ocena;

        return $this;
    }

    /**
     * Get ocena
     *
     * @return integer
     */
    public function getOcena()
    {
        return $this->ocena;
    }

    /**
     * Set waga
     *
     * @param integer $waga
     *
     * @return Oceny
     */
    public function setWaga($waga)
    {
        $this->waga = $waga;

        return $this;
    }

    /**
     * Get waga
     *
     * @return integer
     */
    public function getWaga()
    {
        return $this->waga;
    }

    /**
     * Set kiedy
     *
     * @param \DateTime $kiedy
     *
     * @return Oceny
     */
    public function setKiedy($kiedy)
    {
        $this->kiedy = $kiedy;

        return $this;
    }

    /**
     * Get kiedy
     *
     * @return \DateTime
     */
    public function getKiedy()
    {
        return $this->kiedy;
    }

    /**
     * Set typ
     *
     * @param string $typ
     *
     * @return Oceny
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
     * Set uwagi
     *
     * @param string $uwagi
     *
     * @return Oceny
     */
    public function setUwagi($uwagi)
    {
        $this->uwagi = $uwagi;

        return $this;
    }

    /**
     * Get uwagi
     *
     * @return string
     */
    public function getUwagi()
    {
        return $this->uwagi;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Oceny
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
     * @return Oceny
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
     * @return Oceny
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
