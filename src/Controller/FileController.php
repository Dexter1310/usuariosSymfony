<?php

namespace App\Controller;

use App\Entity\Administrador;
use App\Entity\Tipo;
use App\Form\FilterType;
use App\service\ServiceUser;
use App\service\UserQueryFilter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class FileController extends AbstractController
{
    private $containerSymfony;
    private $serviceUser;

    /**
     * fileController constructor.
     * @param $containerSymfony
     * @param $serviceUser
     */
    public function __construct(ContainerInterface  $containerSymfony,ServiceUser $serviceUser)
    {
        $this->containerSymfony = $containerSymfony;
        $this->serviceUser = $serviceUser;
    }

    /**
     * @Route("/peticion", name="peticion",methods={"POST"})
     * @ParamConverter("filter", class="App\service\UserQueryFilter", options={"alwaysCreate", "params"={"@service_container"}})
     * @param UserQueryFilter|null $filter
     */
    public function list(?UserQueryFilter $filter,Request $request)
    {
        $usuario=$this->serviceUser->findUser();
        $form=$this->createForm(FilterType::class);
        $tipo=$request->request->get('filter_tipo');
        $codigo=$request->request->get('filter_codigo');
        $admin=$request->request->get('filter_admin');
        $adr=$this->getDoctrine()->getRepository(Administrador::class)->find($admin);
        $co=$this->getDoctrine()->getRepository(Tipo::class)->findOneBy(array('codigo' => $codigo));
        $tip=$this->getDoctrine()->getRepository(Tipo::class)->find($tipo);
//           dump($co);
//        die();
//
//dump($tipo." - ".$codigo." - ".$admin);
//;die();
       if(!$filter) {
            $filter = new UserQueryFilter($this->containerSymfony);
            $filter->setAdministrador($adr);
            $filter->setTipo($tip);
            $filter->setCodigo($co);
           $found='Usuarios encontrados: '.count($filter->getResults());
        }
        return $this->render('con1/pagina3.html.twig',['mensaje'=>"usuarios encontrados",'busqueda'=>$usuario,
            'usua'=>$filter->getResults(), 'mens' => $found,'formulari'=>$form->createView()]);
    }
}
