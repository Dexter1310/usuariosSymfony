<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TipoRepository")
 */
class Tipo
{
    const ALIAS='tipo';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"default_tipo"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"default_tipo","nombre_tipo"})
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"default_tipo","nombre_codigo"})
     */
    private $codigo;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Usuario", mappedBy="Tipo")
     * @Serializer\Groups({"complete"})
     */
    private $Usuario;

    /**
     * Tipo constructor.
     * @param $nombre
     * @param $codigo
     * @param $Usuario
     */
    public function __construct($nombre = null, $codigo = null)
    {
        $this->nombre = $nombre;
        $this->codigo = $codigo;
        $this->Usuario = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    public function setCodigo(int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }


     public function setUsuario($Usuario): void
    {
        $this->Usuario = $Usuario;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
}
