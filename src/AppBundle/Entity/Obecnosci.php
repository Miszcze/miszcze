<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Obecnosci
 *
 * @ORM\Table(name="obecnosci", indexes={@ORM\Index(name="fk_uczniowe_has_zajecia_uczniowe1_idx", columns={"uczen"}), @ORM\Index(name="fk_uczniowe_has_zajecia_zajecia1_idx", columns={"termin"})})
 * @ORM\Entity
 */
class Obecnosci
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="kiedy", type="datetime", nullable=false)
     */
    private $kiedy;

    /**
     * @var integer
     *
     * @ORM\Column(name="obecny", type="integer", nullable=false)
     */
    private $obecny;

    /**
     * @var string
     *
     * @ORM\Column(name="komentarz", type="text", length=65535, nullable=true)
     */
    private $komentarz;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Terminarz
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Terminarz")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="termin", referencedColumnName="id")
     * })
     */
    private $termin;

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
     * Set kiedy
     *
     * @param \DateTime $kiedy
     *
     * @return Obecnosci
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
     * Set obecny
     *
     * @param integer $obecny
     *
     * @return Obecnosci
     */
    public function setObecny($obecny)
    {
        $this->obecny = $obecny;

        return $this;
    }

    /**
     * Get obecny
     *
     * @return integer
     */
    public function getObecny()
    {
        return $this->obecny;
    }

    /**
     * Set komentarz
     *
     * @param string $komentarz
     *
     * @return Obecnosci
     */
    public function setKomentarz($komentarz)
    {
        $this->komentarz = $komentarz;

        return $this;
    }

    /**
     * Get komentarz
     *
     * @return string
     */
    public function getKomentarz()
    {
        return $this->komentarz;
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
     * Set termin
     *
     * @param \AppBundle\Entity\Terminarz $termin
     *
     * @return Obecnosci
     */
    public function setTermin(\AppBundle\Entity\Terminarz $termin = null)
    {
        $this->termin = $termin;

        return $this;
    }

    /**
     * Get termin
     *
     * @return \AppBundle\Entity\Terminarz
     */
    public function getTermin()
    {
        return $this->termin;
    }

    /**
     * Set uczen
     *
     * @param \AppBundle\Entity\Uczniowie $uczen
     *
     * @return Obecnosci
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
}
