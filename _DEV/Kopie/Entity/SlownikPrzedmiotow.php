<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SlownikPrzedmiotow
 *
 * @ORM\Table(name="slownik_przedmiotow")
 * @ORM\Entity
 */
class SlownikPrzedmiotow
{
    /**
     * @var string
     *
     * @ORM\Column(name="nazwa", type="string", length=30, nullable=false)
     */
    private $nazwa;

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
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return SlownikPrzedmiotow
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * Set opis
     *
     * @param string $opis
     *
     * @return SlownikPrzedmiotow
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
