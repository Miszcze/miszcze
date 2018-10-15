<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Uzytkownicy
 *
 * @ORM\Table(name="uzytkownicy", uniqueConstraints={@ORM\UniqueConstraint(name="login_UNIQUE", columns={"login"})})
 * @ORM\Entity
 */
class Uzytkownicy
{
    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=45, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="sol", type="string", length=10, nullable=false)
     */
    private $sol;

    /**
     * @var string
     *
     * @ORM\Column(name="typ", type="string", length=20, nullable=false)
     */
    private $typ;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=60, nullable=false)
     */
    private $mail;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
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
     * Set login
     *
     * @param string $login
     *
     * @return Uzytkownicy
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set sol
     *
     * @param string $sol
     *
     * @return Uzytkownicy
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
     * Set typ
     *
     * @param string $typ
     *
     * @return Uzytkownicy
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
     * Set mail
     *
     * @param string $mail
     *
     * @return Uzytkownicy
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Uzytkownicy
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
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
}
