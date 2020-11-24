<?php

namespace App\Entity;

use DigitalAscetic\BaseEntityBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 */
class Usuario extends BaseEntity
{
    const alias ="alias";
    const VIEW_DEFAULT = "default";
    const VIEW_COMPLETE = "complete";
    const VIEW_LIST_TIPO_NOMBRE="nombre_tipo";


    public static function getSerializationGroups(string $view)
    {
        switch ($view) {
            case self::VIEW_DEFAULT:
                $result = array(
                    "id",
                    "default_usu",
                );

                return array_merge(
                    $result,
                    Tipo::getSerializationGroups(Tipo::VIEW_DEFAULT),
                    Administrador::getSerializationGroups(Administrador::VIEW_DEFAULT)
                );
            case self::VIEW_COMPLETE:
                return [
                    "id",
                    "default",
                    "complete",
                ];
            case self::VIEW_LIST_TIPO_NOMBRE:
                return [
                    "id",
                    "nombre_usu",//fitra solo nombre de usuario
                    "nombre_tipo",//filtra por el nombre del tipo
                    "nombre_codigo",//filtra por el código
                ];
        }
    }
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Groups({"default_usu"})
     */
    private $nombre;
    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Groups({"default_usu"})

     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=500)
     * @Serializer\Type("string")
     * @Serializer\Groups({"default_usu"})
     */
    private $adress;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Type("int")
     * @Serializer\Groups({"default_usu"})
     */
    private $phone;


    /**
     * @var Tipo
     * @ORM\ManyToOne(targetEntity="App\Entity\Tipo", inversedBy="Usuario",cascade={"persist"})
     * @Serializer\Type("App\Entity\Tipo")
     * @Serializer\Groups({"default_usu"})

     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Administrador", inversedBy="Usuario",cascade={"persist"})
     * @Serializer\Type("App\Entity\Administrador")
     * @Serializer\Groups({"default_usu"})

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
