<?php

namespace OpenTribes\Core\Silex\Validator;

use OpenTribes\Core\Validator\RegistrationValidator;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Constraints;

class SymfonyRegistrationValidator extends RegistrationValidator
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

                'isUniqueEmail' => new Constraints\IsTrue(['message' => 'Email exists']),
                'isUniqueUsername' => new Constraints\IsTrue(['message' => 'Username exists']),
                'termsAndConditions' => new Constraints\IsTrue(['message' => 'Terms and Conditions are not accepted']),
                'username' => [
                    new Constraints\NotBlank(['message' => 'Username is empty']),
                    new Constraints\Length([
                        'min' => 3,
                        'max' => 20,
                        'minMessage' => 'Username is too short',
                        'maxMessage' => 'Username is too long'
                    ]),
                    new Constraints\Regex([
                        'pattern' => '/^[-a-z0-9_]++$/iD',
                        'message' => 'Username contains invalid character'
                    ])
                ],
                'email' => [
                    new Constraints\NotBlank(['message' => 'Email is empty']),
                    new Constraints\Email(['message' => 'Email is invalid'])
                ],
                'password' => [
                    new Constraints\NotBlank(['message' => 'Password is empty']),
                    new Constraints\Length(['min' => 6, 'minMessage' => 'Password is too short']),
                ],
                'passwordConfirm' => [
                    new Constraints\EqualTo(['value' => $this->password, 'message' => 'Password confirm not match'])
                ],
                'emailConfirm' => [
                    new Constraints\EqualTo(['value' => $this->email, 'message' => 'Email confirm not match'])
                ]
            ]);

        $value = [
            'username' => $this->username,
            'password' => $this->password,
            'isUniqueEmail' => !$this->emailExists,
            'isUniqueUsername' => !$this->usernameExists,
            'termsAndConditions' => $this->acceptedTerms,
            'email' => $this->email,
            'passwordConfirm' => $this->passwordConfirm,
            'emailConfirm' => $this->emailConfirm
        ];
        $result = $this->validator->validate($value, $constraint);
        if ($result instanceof ConstraintViolationList) {
            foreach ($result->getIterator() as $constraintViolation) {
                $this->addError($constraintViolation->getMessage());
            }
        }

    }

}