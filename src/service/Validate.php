<?php


namespace App\service;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class Validate

{
    private $validator;
    private $registry;

    /**
     * Validate constructor.
     * @param ValidatorInterface $validator
     * @param Registry $registry
     */
    public function __construct(ValidatorInterface $validator, Registry $registry)
    {
        $this->validator = $validator;
        $this->registry = $registry;
    }

    public function validaterequest($data)
    {
        $errors = $this->validator->validate($data);
        $errorResponsive = array();
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $errorResponsive[] = [
                'field' => $error->getPropertyPath(),
                'message' => $error->getMessage()
            ];
        }
        if (count($errors)) {
            $respose = array(
                'code' => 1,
                'messagesss' => 'validation errors',
                'errors' => $errorResponsive,
                'result' => null);
            return $respose;
        } else {
            $respose = [];
            return $respose;
        }

    }
}