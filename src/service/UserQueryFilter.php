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
     * @var Tipo|null
     */
    private $tipo;
    /**
     * @var Administrador|null
     */
    private $administrador;
    /**
     * @var Tipo|null
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
                ->setParameter('type', $this->tipo->getId());
        }
        if (!is_null($this->administrador)) {
            $this->qb->join($aliasUsuario.'.admin',Administrador::ALIAS)
                ->andwhere(Administrador::ALIAS.'.id=:idAdmin')
                ->setParameter('idAdmin', $this->administrador->getId());
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
     * @return Tipo|null
     */
    public function getTipo(): ?Tipo
    {
        return $this->tipo;
    }

    /**
     * @param Tipo|null $tipo
     */
    public function setTipo(?Tipo $tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return Administrador|null
     */
    public function getAdministrador(): ?Administrador
    {
        return $this->administrador;
    }

    /**
     * @param Administrador|null $administrador
     */
    public function setAdministrador(?Administrador $administrador): void
    {
        $this->administrador = $administrador;
    }

    /**
     * @return Tipo|null
     */
    public function getCodigo(): ?Tipo
    {
        return $this->codigo;
    }

    /**
     * @param Tipo|null $codigo
     */
    public function setCodigo(?Tipo $codigo): void
    {
        $this->codigo = $codigo;
    }




}