<?php

namespace App\Controller;
use App\Entity\Administrador;
use App\Entity\Tipo;
use App\Form\AdministradorType;
use App\Repository\UsuarioRepository;
use App\service\NewMessage;
use App\Entity\Usuario;
use App\Form\UsuType;
use App\service\ServiceUser;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Tests\A;

class Con1Controller extends AbstractController
{
    /** @var NewMessage $men */
    private $men;
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;
    /** @var ServiceUser $serviceUser */
    private $serviceUser;

    /**
     * Con1Controller constructor.
     * @param $men
     * @param $entityManager
     * @param $serviceUser
     */
    public function __construct(NewMessage $men,EntityManagerInterface $entityManager,ServiceUser $serviceUser)
    {
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
     * @Route("/pagina3/", name="pagina3")
     */

    public function pagina3Action(Request $request)
    {
        $usuario=$this->serviceUser->findUser();
        /** @var  $number int */
     $number=null;
     $usua=null;
        $form = $this->createFormBuilder()
            ->add('tipo',EntityType::class,['class'=>Tipo::class,'choice_label'=>'nombre','label'=>'Mostrar usuarios por tipo:'])
            ->add('Filtrar',SubmitType::class)->getForm();

        $form2 = $this->createFormBuilder()
            ->add('admin',EntityType::class,['class'=>Administrador::class,'choice_label'=>'nombre','label'=>'Mostrar usuarios asociados al administrador:'])
            ->add('Filtro',SubmitType::class)->getForm();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            $form2->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();
                $number=$user['tipo']->getId();
                $usua=$this->entityManager->getRepository(Usuario::class)->findUserType($number);
            }
            if ($form2->isSubmitted() && $form2->isValid()) {
                $user2 = $form2->getData();
                $user2 = $form2->getData();
                $number=$user2['admin']->getId();
                $usua=$this->serviceUser->findUsuarioByAdmin($number);
            }

        }


        return $this->render('con1/pagina3.html.twig',['busqueda'=>$usuario,'mensaje'=>'',
            'usua'=>$usua,'mens'=>$number,'formulari'=>$form->createView(),'formulari2'=>$form2->createView()]);
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
        return $this->redirectToRoute('pagina3',['mensaje'=>'Usuario: '.$usuario->getNombre().'.']);

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