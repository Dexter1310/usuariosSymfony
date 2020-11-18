<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 */
class Usuario
{
    const alias ="alias";
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $adress;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tipo", inversedBy="Usuario",cascade={"persist"})
     */
    private $tipo;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Administrador", inversedBy="Usuario",cascade={"persist"})
     */
    private $admin;


    /**
     * Usuario constructor.
     * @param $nombre
     * @param $mail
     * @param $adress
     * @param $phone
     */
    public function __construct($nombre=null, $mail=null, $adress=null, $phone=null)
    {
        $this->nombre = $nombre;
        $this->mail = $mail;
        $this->adress = $adress;
        $this->phone = $phone;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin): void
    {
        $this->admin = $admin;
    }



}
