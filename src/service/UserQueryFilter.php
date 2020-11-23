<?php
namespace App\service;

use App\Entity\Administrador;
use App\Entity\Tipo;
use App\Entity\Usuario;
use DigitalAscetic\QueryFilterBundle\QueryFilter\Doctrine\AbstractDoctrineQueryFilter;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class QolRecordQueryFilter
 * @package DWSBundle\Service
 */
class UserQueryFilter extends AbstractDoctrineQueryFilter
{
    /**
     * @var int|null
     */
    private $tipo;
    /**
     * @var int|null
     */
    private $administrador;
    /**
     * @var int|null
     */
    private $codigo;

//    /**
//     * AbstractDoctrineQueryFilter constructor.
//     * @param ContainerInterface $container
//     */
//    public function __construct(
//        ContainerInterface $container = null
//    )
//    {
//        parent::__construct($container);
//    }

    protected function applyFilter()
    {
        $aliasUsuario = $this->getBaseClassAlias();

        if (!is_null($this->tipo)) {
            $this->qb->andwhere($aliasUsuario.'.tipo=:type')
                ->setParameter('type', $this->tipo);
        }
        if (!is_null($this->administrador)) {
            $this->qb->join($aliasUsuario.'.admin',Administrador::ALIAS)
                ->andwhere(Administrador::ALIAS.'.id=:idAdmin')
                ->setParameter('idAdmin', $this->administrador);
        }
        if (!is_null($this->codigo)) {
            $this->qb->join(Usuario::alias.'.tipo',Tipo::ALIAS)
                ->andwhere(Tipo::ALIAS.'.codigo=:codigo')
                ->setParameter('codigo', $this->codigo);
        }
    }

    protected function getBaseClass(): string
    {
        return Usuario::class;
    }
    protected function getBaseClassAlias(): string
    {
        return Usuario::alias;
    }

    /**
     * @return int|null
     */
    public function getTipo(): ?int
    {
        return $this->tipo;
    }

    /**
     * @param int|null $tipo
     */
    public function setTipo(?int $tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return int|null
     */
    public function getAdministrador(): ?int
    {
        return $this->administrador;
    }

    /**
     * @param int|null $administrador
     */
    public function setAdministrador(?int $administrador): void
    {
        $this->administrador = $administrador;
    }

    /**
     * @return int|null
     */
    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    /**
     * @param int|null $codigo
     */
    public function setCodigo(?int $codigo): void
    {
        $this->codigo = $codigo;
    }



}