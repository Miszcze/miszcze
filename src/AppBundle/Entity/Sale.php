<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sale
 *
 * @ORM\Table(name="sale", uniqueConstraints={@ORM\UniqueConstraint(name="nr_sali_UNIQUE", columns={"nr_sali"})})
 * @ORM\Entity
 */
class Sale
{
    /**
     * @var string
     *
     * @ORM\Column(name="nr_sali", type="string", length=4, nullable=false)
     */
    private $nrSali;

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
     * Set nrSali
     *
     * @param string $nrSali
     *
     * @return Sale
     */
    public function setNrSali($nrSali)
    {
        $this->nrSali = $nrSali;

        return $this;
    }

    /**
     * Get nrSali
     *
     * @return string
     */
    public function getNrSali()
    {
        return $this->nrSali;
    }

    /**
     * Set opis
     *
     * @param string $opis
     *
     * @return Sale
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
}
