<?php

namespace OpenTribes\Core\Silex\Validator;

use OpenTribes\Core\ValidationDto\Registration as RegistrationValidatorDto;
use OpenTribes\Core\Validator\Registration as AbstractRegistrationValidator;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator;

/**
 * Description of RegistrationValidator
 * @author BlackScorp<witalimik@web.de>
 */
class Registration extends AbstractRegistrationValidator
{

    private $validator;

    public function __construct(RegistrationValidatorDto $object, Validator $validator)
    {
        parent::__construct($object);
        $this->validator = $validator;
    }

    public function validate()
    {
        $object = $this->getObject();

        $constraint = new Assert\Collection(array(
            'isUniqueEmail' => new Assert\True(array('message' => 'Email exists')),
            'isUniqueUsername' => new Assert\True(array('message' => 'Username exists')),
            'termsAndConditions' => new Assert\True(array('message' => 'Terms and Conditions are not accepted')),
            'username' => array(
                new Assert\NotBlank(array('message' => 'Username is empty')),
                new Assert\Length(array(
                    'min' => 3,
                    'max' => 20,
                    'minMessage' => 'Username is too short',
                    'maxMessage' => 'Username is too long'
                )),
                new Assert\Regex(array(
                    'pattern' => '/^[-a-z0-9_]++$/iD',
                    'message' => 'Username contains invalid character'
                ))
            ),
            'email' => array(
                new Assert\NotBlank(array('message' => 'Email is empty')),
                new Assert\Email(array('message' => 'Email is invalid'))
            ),
            'password' => array(
                new Assert\NotBlank(array('message' => 'Password is empty')),
                new Assert\Length(array('min' => 6, 'minMessage' => 'Password is too short')),
            ),
            'passwordConfirm' => array(
                new Assert\EqualTo(array('value' => $object->password, 'message' => 'Password confirm not match'))
            ),
            'emailConfirm' => array(
                new Assert\EqualTo(array('value' => $object->email, 'message' => 'Email confirm not match'))
            )
        ));

        $result = $this->validator->validateValue((array)$object, $constraint);
        if ($result instanceof ConstraintViolationList) {
            foreach ($result->getIterator() as $contraintViolation) {
                $this->attachError($contraintViolation->getMessage());
            }
        }
    }
}
