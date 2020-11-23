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


    protected function applyFilter()
    {
        $aliasUsuario = $this->getBaseClassAlias();

        if (!is_null($this->tipo)) {
            $this->qb->andwhere($aliasUsuario.'.tipo=:type')
                ->setParameter('type', $this->tipo);
        }
        if (!is_null($this->administrador)) {
            $this->qb->andwhere(Administrador::ALIAS.'.id=:idAdmin')
                ->setParameter('idAdmin', $this->administrador);
        }
        if (!is_null($this->codigo)) {
            $this->qb->andwhere(Tipo::ALIAS.'.codigo=:codigo')
                ->setParameter('codigo', $this->codigo);
        }
    }

    protected function getJoins(): array
    {
        $parentJoins = parent::getJoins();

        /**
         * Hacemos una array_merge, para juntar los joins de la clase padre y los de nuestra clase.
         * Es importante que los joins de la clase padre, se situen primeros en el array
         */
        return array_merge(
            $parentJoins,
            [
                ['type' => 'inner', 'prop' =>  $this->getBaseClassAlias().'.admin', 'alias' => Administrador::ALIAS],
                ['type' => 'inner', 'prop' =>  $this->getBaseClassAlias().'.tipo', 'alias' => Tipo::ALIAS]
//                ['inner', $this->getBaseClassAlias().'.admin', Administrador::ALIAS],
//                ['inner', $this->getBaseClassAlias().'.tipo', Tipo::ALIAS]
            ]
        );
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