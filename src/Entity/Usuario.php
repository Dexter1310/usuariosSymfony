<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

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
     * @Serializer\Type("int")
     * @Serializer\Groups({"default"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Groups({"default"})
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Groups({"default"})
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=500)
     * @Serializer\Type("string")
     * @Serializer\Groups({"default"})
     */
    private $adress;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Type("int")
     * @Serializer\Groups({"default"})
     */
    private $phone;


    /**
     * @var Tipo
     * @ORM\ManyToOne(targetEntity="App\Entity\Tipo", inversedBy="Usuario",cascade={"persist"})
     * @Serializer\Type("App\Entity\Tipo")
     * @Serializer\Groups({"default"})
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Administrador", inversedBy="Usuario",cascade={"persist"})
     * @Serializer\Type("App\Entity\Administrador")
     * @Serializer\Groups({"default"})
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
     * @return Tipo
     */
    public function getTipo(): Tipo
    {
        return $this->tipo;
    }

    /**
     * @param Tipo $tipo
     */
    public function setTipo(Tipo $tipo): void
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
