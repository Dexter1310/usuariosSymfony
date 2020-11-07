<?php

namespace App\Controller;
use App\Entity\Tipo;
use App\Entity\Usuario;
use App\Form\UsuType;
use App\service\ServiceUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class Con1Controller extends AbstractController
{
    /** @var EntityManagerInterface  */
    private $entityManager;

    /** @var ServiceUser */
    private $serviceUser;
    /**
     * Con1Controller constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, ServiceUser $serviceUser)
    {
        $this->entityManager = $entityManager;
        $this->serviceUser=$serviceUser;
    }
    /**
         * @Route("/", name="index")
    */
    public function index(){
        $nu1=10;
        $nu2=100;
        $suma = $nu1+$nu2;
        $nombre= "albert,juan,pedro,sergio";
        return $this->render('con1/index.html.twig', ['controller_name' => 'Javi','sumados'=>$suma,'n1'=>$nu1,'n2'=>$nu2,
            'nombres'=>$nombre]);
    }

     /**  crear
     * @Route("/pagina2/{nom}/{formu}/", name="pagina2")
     */
    public function pagina2($nom,$formu,Request $request)
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
                'parametro1' => $nom,
                'form' => $formu,
                'formul' => $form->createView(),
            ]
        );

    }
     /** visualizar
     * @Route("/pagina3/", name="pagina3")
     */

     public function pagina3()
    {
        $usuario=$this->serviceUser->findUser();
        return $this->render('con1/pagina3.html.twig',array('busqueda'=>$usuario,'mensaje'=>''));
    }

    /**  Actualizar
     * @Route("/pagina4/{id}", requirements={"id" = "^\d+$"}, name="update")
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

                return $this->redirectToRoute(
                    'pagina3',
                    ['mensaje' => 'Usuario con id:'.$usuario->getId().' actualizado']
                );
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

    /**
     * @Route("/crear/", name="pagina4")
     */

/// TODO:MODO PRUEBA : crear manualmente desde la vista /crear desde la url
    public function  crear()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $usuari = new Usuario('Pablo', "pablo@gmail.com", "Santmonica", 699594539);
        $tipo = new Tipo('jefe',2);
        $usuari->setTipo($tipo);
        $entityManager->persist($usuari);
        $entityManager->flush();
        return $this->render('con1/succes.html.twig');

    }

}

