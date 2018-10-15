<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GodzLek
 *
 * @ORM\Table(name="godz_lek")
 * @ORM\Entity
 */
class GodzLek
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="poczatek", type="datetime", nullable=false)
     */
    private $poczatek;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set poczatek
     *
     * @param \DateTime $poczatek
     *
     * @return GodzLek
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
