<?php

namespace App\Entity;

use DigitalAscetic\BaseEntityBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TipoRepository")
 */
class Tipo extends BaseEntity
{
    const ALIAS='tipo';
    const VIEW_DEFAULT="default";
    public static function getSerializationGroups(string $view)
    {
        switch ($view) {
            case self::VIEW_DEFAULT:
                return [
                    "id",
                    "default_tipo",
                ];
        }
    }

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"default_tipo"})
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"default_tipo"})
     */
    private $codigo;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Usuario", mappedBy="Tipo")
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

}
