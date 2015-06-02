<?php

namespace OpenTribes\Core\Silex\Validator;


use OpenTribes\Core\Validator\LoginValidator;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Constraints;


class SymfonyLoginValidator extends LoginValidator
{
    /**
     * @var Validator
     */
    private $validator;

    public function __construct(Validator\RecursiveValidator $validator)
    {
        $this->validator = $validator;
    }

    protected function validate()
    {
        $constraint = new Constraints\Collection(
            [

                'username' => [
                    new Constraints\NotBlank(array('message' => 'Username is empty')),
                    new Constraints\Length(array(
                        'min' => 3,
                        'max' => 20,
                        'minMessage' => 'Username is too short',
                        'maxMessage' => 'Username is too long'
                    )),
                    new Constraints\Regex(array(
                        'pattern' => '/^[-a-z0-9_]++$/iD',
                        'message' => 'Username contains invalid character'
                    ))
                ]
                ,
                'password' => [
                    new Constraints\NotBlank(array('message' => 'Password is empty')),
                    new Constraints\Length(array('min' => 6, 'minMessage' => 'Password is too short')),

                ],
                'verified' => [
                    new Constraints\IsTrue(['message' => 'Invalid login'])
                ]
            ]);

        $value = [
            'username' => $this->username,
            'password' => $this->password,
            'verified' => $this->verified
        ];
        $result = $this->validator->validate($value, $constraint);
        if ($result instanceof ConstraintViolationList) {
            foreach ($result->getIterator() as $constraintViolation) {
                $this->addError($constraintViolation->getMessage());
            }
        }

    }

}