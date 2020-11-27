<?php

namespace App\Controller;

use App\Entity\Administrador;
use App\Entity\Tipo;
use App\Entity\Usuario;
use App\Form\FilterType;
use App\service\ServiceUser;
use App\service\UserQueryFilter;
use DigitalAscetic\BaseEntityBundle\Controller\BaseWebServiceController;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class FileController extends BaseWebServiceController
{
    private $containerSymfony;
    private $serviceUser;
    /**
     * FileController constructor.
     * @param $containerSymfony
     * @param $serviceUser
     */
    public function __construct(
        ContainerInterface $containerSymfony,
        ServiceUser $serviceUser
    ) {
        $this->containerSymfony = $containerSymfony;
        $this->serviceUser = $serviceUser;
    }
    /**
     * @Route("/peticion", name="peticion", methods={"GET", "OPTIONS"})
     * @ParamConverter("filter", class="App\service\UserQueryFilter", options={"alwaysCreate", "params"={"@service_container"}})
     */
    public function list(UserQueryFilter $filter, Request  $request)
    {
        $paged = $filter->getPagedResults();
        $filter->setEnabled(1);
        $response = [
            'recordsTotal' => $paged->getTotalItems(),
            'recordsFiltered' => $paged->getTotalItems(),
            'data' => $filter->getResults(),
        ];

        $jsonContent = $this->serializer->serialize(
            $response,
            'json',
            SerializationContext::create()
                ->setGroups(Usuario::getSerializationGroups(Usuario::VIEW_DEFAULT))
                ->setSerializeNull(true)
        );
        $headers['Content-Type'] = 'application/json';
        return new Response($jsonContent, 200, $headers);
    }
}
