<?php

namespace App\Controller;
use App\Entity\Administrador;
use App\Entity\Tipo;
use App\Form\AdministradorType;
use App\Form\FilterType;
use App\Repository\UsuarioRepository;
use App\service\NewMessage;
use App\Entity\Usuario;
use App\Form\UsuType;
use App\service\ServiceUser;
use App\service\UserQueryFilter;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Con1Controller extends AbstractController
{
    /** @var NewMessage $men */
    private $men;
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;
    /** @var ServiceUser $serviceUser */
    private $serviceUser;

    /**
     * @var ContainerInterface $container
     */
    protected $containerSymfony;

    /**
     * Con1Controller constructor.
     * @param $men
     * @param $entityManager
     * @param $serviceUser
     * @param $userQueryFilter
     */
    public function __construct(ContainerInterface $container, NewMessage $men, EntityManagerInterface $entityManager, ServiceUser $serviceUser,UserQueryFilter $userQueryFilter)
    {
        $this->containerSymfony = $container;
        $this->men = $men;
        $this->entityManager = $entityManager;
        $this->serviceUser = $serviceUser;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request){
        $code=null;
        $formCode = $this->createFormBuilder()->add('codigo')
            ->add('buscar',SubmitType::class)->getForm();
        if ($request->getMethod() == 'POST') {
            $formCode->handleRequest($request);
            if ($formCode->isSubmitted() && $formCode->isValid()) {
                $userCode = $formCode->getData();
                $code=$userCode['codigo'];
            }
        }
        $usu=$this->serviceUser->findUsuarioByCodigoTipo($code);
        return $this->render("con1/index.html.twig",['formCode'=>$formCode->createView(),'nombre'=>$usu]);
    }

    /**  crear
     * @Route("/pagina2/", name="pagina2", methods={"POST","GET"} )
     */
    public function pagina2(Request $request)
    {
        $form = $this->createForm(UsuType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Usuario $user */
            $user = $form->getData();
            $this->serviceUser->persistUser($user);
            return $this->redirectToRoute('pagina3');
        }
        return $this->render(
            'con1/pagina2.html.twig',
            [
                'variable2' => 'Agregar usuario',
                'formul' => $form->createView(),
            ]
        );
    }

    /** visualizar
     * @Route("/pagina3/", name="pagina3",methods={"POST","GET"})
     */
    public function pagina3Action(Request $request)
    {
        $usuario=$this->serviceUser->findUser();
        /** @var  $number int */
     $number=null;
     $usua=null;
     $found=null;
        $form=$this->createForm(FilterType::class);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var FilterType $filter */
                $filter = $form->getData();
                //Todo:función para comprobar los select que han sido filtrados:
//               $usua=$this->serviceUser->filter($filter['tipo'],$filter['admin'],$filter['codigo']);
                $newQF=new UserQueryFilter($this->containerSymfony);

                $newQF->setAdministrador($filter['admin']);
                $newQF->setTipo($filter['tipo']->getId());
                $newQF->setCodigo($filter['codigo']);
                $usua=$newQF->getResults();
                $found='Usuarios encontrados: '.count($usua);
            }
        }

        return $this->render('con1/pagina3.html.twig',['busqueda'=>$usuario,'mensaje'=>$found,
            'usua'=>$usua,'mens'=>$number,'formulari'=>$form->createView()]);
    }






    /**  Actualizar
     * @Route("/pagina4/{id}", requirements={"id" = "^\d+$"}, name="update", methods={"POST","GET"})
     * @ParamConverter("usuario", class="App\Entity\Usuario")
     */
    public function actualizar(Usuario $usuario,Request $request)
    {
        /**
         * Al método createForm, se le puede pasar el objeto con el que inicializar el formulario.
         * En este caso inicializamos el formulario UsuType, con los valores del objeto $usuario
         */
        $form = $this->createForm(UsuType::class, $usuario);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();
                $this->serviceUser->persistUser($user);
                $this->addFlash(
                    'success','Usuario '.$usuario->getNombre().' actualizado.'
                );
                $userCreate='Usuario '.$usuario->getNombre().' actualizado.';
                return $this->redirectToRoute('pagina3', ['mensaje' => $userCreate]);
            }
        }

        return $this->render('con1/pagina4.html.twig', ['variable2' => 'Actualizar', 'usuario'=>$usuario, 'formul'=>$form->createView()]
        );
    }
    /**  Eliminar
     * @Route("/pagina3/{id}/", requirements={"id" = "^\d+$"}, name="borrar")
     * @ParamConverter("usuario", class="App\Entity\Usuario")
     */
    public function borrar(Usuario $usuario)
    {
        /**
         * Guardo el id del usuario en la variable, antes de borrarlo (de otro modo, no tendria acceso al valor)
         */
        $ide = $usuario->getId();
        $this->serviceUser->removeUser($usuario);
        return $this->redirectToRoute('pagina3',['mensaje'=>'Usuario con id:'.$ide.' eliminado']);
    }
//    Todo: encontrar usuario por id
    /**
     * @Route("/user/{id}", name="user_show")
     * @ParamConverter("usuario", class="App\Entity\Usuario")
     */
    public function show(Usuario $usuario)
    {
        $us = $usuario->getId();
        if (!$us) {
            throw $this->createNotFoundException(
                'No User found for id '.$us
            );
        }
        return $this->redirectToRoute('pagina3',['mensaje'=>
            'Usuario: '.$usuario->getNombre().' - Tipo: '.$usuario->getTipo()->getNombre().' - Administrador : '.$usuario->getAdmin()->getNombre()]);
    }
    /**
     * @Route("/findAdmin", name="findAdmin",methods={"POST","GET"})
     */
    public function findAdmin(Request $request)
    {
        $formAdmin=$this->createForm(AdministradorType::class);
        if ($request->getMethod() == 'POST') {
            $formAdmin->handleRequest($request);
            if ($formAdmin->isSubmitted() && $formAdmin->isValid()) {
                $admin = $formAdmin->getData();
                $mens=$this->serviceUser->findParameter($admin->getTipo());
                $nombre=$mens->getNombre();
                return $this->redirectToRoute('pagina3',['mensaje'=>$nombre]);
            }
            }
        return $this->render("con1/findAdmin.html.twig",['formAdmin'=>$formAdmin->createView()]);
    }

}