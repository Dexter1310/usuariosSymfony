<?php

namespace App\Controller;

use App\Entity\Administrador;
use App\Entity\Tipo;
use App\Form\FilterType;
use App\service\ServiceUser;
use App\service\UserQueryFilter;
use DigitalAscetic\BaseEntityBundle\Controller\BaseWebServiceController;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class FileController extends BaseWebServiceController
{
    private $containerSymfony;
    private $serviceUser;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * FileController constructor.
     * @param $containerSymfony
     * @param $serviceUser
     */
    public function __construct(
        ContainerInterface $containerSymfony,
        ServiceUser $serviceUser,
        SerializerInterface $serializer
    ) {
        $this->containerSymfony = $containerSymfony;
        $this->serviceUser = $serviceUser;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/peticion", name="peticion", methods={"GET", "OPTIONS"})
     * @ParamConverter("filter", class="App\service\UserQueryFilter", options={"alwaysCreate", "params"={"@service_container"}})
     */
    public function list(UserQueryFilter $filter)
    {
        /**
         * Reemplazar todo este codigo por $this->>jsonResponse() incluido en BaseWebServiceController
         */


        $serializationContext = SerializationContext::create();
        $results = $filter->getResults();
        $json = $this->serializer->serialize(
            ['data' => $results],
            'json',
            $serializationContext->setGroups(['default'])->setSerializeNull(true)
        );

        return new JsonResponse($json, 200, [], true);
    }
}
