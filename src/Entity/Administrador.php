<?php

namespace App\Entity;

use DigitalAscetic\BaseEntityBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdministradorRepository")
 */
class Administrador extends BaseEntity
{
    const PRINCIPAL=1;
    const ADMIN=2;
    const OF1=3;
    const OF2=4;
    const ALIAS="admin";
    const VIEW_DEFAULT="default";

    public static function getSerializationGroups(string $view)
    {
        switch ($view) {
            case self::VIEW_DEFAULT:
                return [
                    "id",
                    "default_admin",
                ];
        }
    }

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"default_admin"})
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"default_admin"})
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"default_admin"})
     */
    private $categoria;


    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getTipo(): ?int
    {
        return $this->tipo;
    }

    public function setTipo(int $tipo): self
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria): void
    {
        $this->categoria = $categoria;
    }

}
