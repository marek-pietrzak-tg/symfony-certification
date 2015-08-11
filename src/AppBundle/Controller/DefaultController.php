<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator;

class DefaultController extends Controller
{
    /**
     * @Route("/app/example", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/app/validate", name="validate")
     */
    public function validateAction()
    {
        $validator = $this->get('validator');
        $user = new User('Marek');

        $errors = $validator->validate($user);
        var_dump($errors);
        //object(Symfony\Component\Validator\ConstraintViolationList)#547 (1) { ["violations":"Symfony\Component\Validator\ConstraintViolationList":private]=> array(0) { } }

        $errors = $validator->validate($user, ['admin']);
        var_dump($errors);

        /*
         * object(Symfony\Component\Validator\ConstraintViolationList)#588 (1) {
         *   ["violations":"Symfony\Component\Validator\ConstraintViolationList":private]=> array(1) {
         *     [0]=> object(Symfony\Component\Validator\ConstraintViolation)#591 (8) {
         *       ["message":"Symfony\Component\Validator\ConstraintViolation":private]=> string(31) "This value should not be blank."
         *       ["messageTemplate":"Symfony\Component\Validator\ConstraintViolation":private]=> string(31) "This value should not be blank."
         *       ["messageParameters":"Symfony\Component\Validator\ConstraintViolation":private]=> array(1) {
         *         ["{{ value }}"]=> string(4) "null" }
         *       ["messagePluralization":"Symfony\Component\Validator\ConstraintViolation":private]=> NULL
         *       ["root":"Symfony\Component\Validator\ConstraintViolation":private]=> object(AppBundle\Entity\User)#545 (2) {
         *         ["adminPassword":"AppBundle\Entity\User":private]=> NULL
         *         ["name":"AppBundle\Entity\User":private]=> string(5) "Marek" }
         *         ["propertyPath":"Symfony\Component\Validator\ConstraintViolation":private]=> string(13) "adminPassword"
         *         ["invalidValue":"Symfony\Component\Validator\ConstraintViolation":private]=> NULL
         *         ["code":"Symfony\Component\Validator\ConstraintViolation":private]=> NULL } } }
         */
        return new Response();
    }
}
