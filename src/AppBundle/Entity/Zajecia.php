<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zajecia
 *
 * @ORM\Table(name="zajecia", indexes={@ORM\Index(name="termin", columns={"termin"})})
 * @ORM\Entity
 */
class Zajecia
{
    /**
     * @var string
     *
     * @ORM\Column(name="temat", type="string", length=255, nullable=false)
     */
    private $temat;

    /**
     * @var string
     *
     * @ORM\Column(name="opis", type="text", length=65535, nullable=true)
     */
    private $opis;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=false)
     */
    private $data;

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
     * Set temat
     *
     * @param string $temat
     *
     * @return Zajecia
     */
    public function setTemat($temat)
    {
        $this->temat = $temat;

        return $this;
    }

    /**
     * Get temat
     *
     * @return string
     */
    public function getTemat()
    {
        return $this->temat;
    }

    /**
     * Set opis
     *
     * @param string $opis
     *
     * @return Zajecia
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
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Zajecia
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
     * @return Zajecia
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
}
