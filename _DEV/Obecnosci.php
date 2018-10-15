<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Obecnosci
 *
 * @ORM\Table(name="obecnosci", indexes={@ORM\Index(name="fk_uczniowe_has_zajecia_uczniowe1_idx", columns={"uczen"}), @ORM\Index(name="fk_uczniowe_has_zajecia_zajecia1_idx", columns={"zajecia"})})
 * @ORM\Entity
 */
class Obecnosci
{
    /**
     * @var integer
     *
     * @ORM\Column(name="obecny", type="integer", nullable=false)
     */
    private $obecny;

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
     * @var \AppBundle\Entity\Zajecia
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Zajecia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="zajecia", referencedColumnName="id")
     * })
     */
    private $zajecia;



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

    /**
     * Set zajecia
     *
     * @param \AppBundle\Entity\Zajecia $zajecia
     *
     * @return Obecnosci
     */
    public function setZajecia(\AppBundle\Entity\Zajecia $zajecia = null)
    {
        $this->zajecia = $zajecia;

        return $this;
    }

    /**
     * Get zajecia
     *
     * @return \AppBundle\Entity\Zajecia
     */
    public function getZajecia()
    {
        return $this->zajecia;
    }
}
