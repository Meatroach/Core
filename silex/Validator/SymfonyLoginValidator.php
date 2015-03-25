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

    function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    protected function validate()
    {
        $constraint = new Constraints\Collection(
            [
                'username' => [
                    new Constraints\NotBlank(['message' => 'Username is empty']),
                ],
                'password' => [
                    new Constraints\NotBlank(['message' => 'Password is empty']),
                ],
                'verified'=>[
                    new Constraints\True(['message'=>'Invalid login'])
                ]
            ]);
        $value = [
            'username'=>$this->username,
            'password'=>$this->password,
            'verified'=>$this->verified
        ];
        $result = $this->validator->validateValue($value, $constraint);
        if ($result instanceof ConstraintViolationList) {
            foreach($result->getIterator() as $constraintViolation){
                $this->addError($constraintViolation->getMessage());
            }
        }

    }

}