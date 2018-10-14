<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hasla
 *
 * @ORM\Table(name="hasla", indexes={@ORM\Index(name="FK_hasla_uzytkownicy_idx", columns={"uzytkownik"})})
 * @ORM\Entity
 */
class Hasla
{
    /**
     * @var string
     *
     * @ORM\Column(name="haslo", type="string", length=200, nullable=false)
     */
    private $haslo;

    /**
     * @var string
     *
     * @ORM\Column(name="sol", type="string", length=10, nullable=false)
     */
    private $sol;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=false)
     */
    private $data;

    /**
     * @var integer
     *
     * @ORM\Column(name="proby", type="integer", nullable=false)
     */
    private $proby = '0';

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
     * Set haslo
     *
     * @param string $haslo
     *
     * @return Hasla
     */
    public function setHaslo($haslo)
    {
        $this->haslo = $haslo;

        return $this;
    }

    /**
     * Get haslo
     *
     * @return string
     */
    public function getHaslo()
    {
        return $this->haslo;
    }

    /**
     * Set sol
     *
     * @param string $sol
     *
     * @return Hasla
     */
    public function setSol($sol)
    {
        $this->sol = $sol;

        return $this;
    }

    /**
     * Get sol
     *
     * @return string
     */
    public function getSol()
    {
        return $this->sol;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Hasla
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set proby
     *
     * @param integer $proby
     *
     * @return Hasla
     */
    public function setProby($proby)
    {
        $this->proby = $proby;

        return $this;
    }

    /**
     * Get proby
     *
     * @return integer
     */
    public function getProby()
    {
        return $this->proby;
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
     * @return Hasla
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
