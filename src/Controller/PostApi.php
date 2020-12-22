<?php


namespace App\Controller;


use App\Entity\Administrador;
use App\Entity\Tipo;
use App\Entity\Usuario;
//use App\service\Validate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class PostApi extends AbstractController
{
    /**
     * @Route ("/api/{id}",name="show_post")
     */
    public function showPost($id)
    {
        $user = $this->getDoctrine()->getRepository(Usuario::class)->find($id);
        $encoder = new JsonEncoder();
        $dateCallback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ISO8601) : '';
        };
        $defaultContext = [AbstractNormalizer::CALLBACKS => ['createdAt' => $dateCallback,],];

        if (empty($user)) {
            $response = array(
                'code' => 1,
                'message' => 'post',
                'error' => null,
                'result' => null
            );
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }
        $normalizer = new GetSetMethodNormalizer(null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);
        $data = $serializer->serialize($user, 'json');
        $response = array(
            'code' => 0,
            'message' => 'success',
            'errors' => null,
            'result' => json_decode($data)
        );
        return new JsonResponse($response, 200);
    }

    /**
     * @Route ("/admin",name="create_post")
     */
    public function createPost()
    {
//        dump("entra");die();
        $admin=new Administrador();
        $admin->setTipo(Administrador::PRINCIPAL);
        $admin->setNombre("Marta");
        $admin->setCategoria('principal');
        $em = $this->getDoctrine()->getManager();
        $em->persist($admin);
        $em->flush();

//        $serializer2 = new Serializer([new GetSetMethodNormalizer(), new ArrayDenormalizer()], [new JsonEncoder(), new XmlEncoder()]
//        );
//
//        $user = $serializer2->deserialize($us, Usuario::class, 'json');



//        if (!empty($response)) {
//            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
//        }

//        $response = array(
//            'code' => 0,
//            'message' => 'Post Created',
//            'errors' => null,
//            'result' => null
//        );
//        return new JsonResponse($response, Response::HTTP_CREATED);


    }

//    /**
//     * @Route ("/api/posts",name="list_post",methods={"GET"})
//     */
//    public function listPost(Request $request)
//    {
//
//    }
//
//    /**
//     * @param Request $request
//     * @param $id
//     * @Route ("/api/posts/{id}",name="update_post",methods={"PUT"})
//     */
//    public function updatePost(Request $request, $id)
//    {
//
//    }
//
//    /**
//     * @param $id
//     * @Route ("/api/posts/{id}",name="delete_post",methods={"DELETE"})
//     */
//    public function deletePost(Request $request, $id)
//    {
//
//    }

}