<?php
namespace Blumilksoftware\Lmt;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Illuminate\Support\Collection;

class FormValidator
{
    /**
     * @param array<string, string> $formInput
     * @return Collection<string, string>
     */
    public static function validateRegistrationFormInput(array $formInput): Collection
    {
        $validator = Validation::createValidator();
        $errors = new Collection();

        $errors->put("email", $validator->validate($formInput["email"], [
            new Email(message: "Niepoprawny adres e-mail"),
            new NotBlank(message: "E-mail jest wymagany")
        ]));

        $errors->put("name", $validator->validate($formInput["name"], [
            new NotBlank(message: "Imię jest wymagane"),
            new Length(
                min: 2, max: 50,
                minMessage: "Imię musi mieć co najmniej 2 znaki",
                maxMessage: "Imię może mieć maksymalnie 50 znaków"
            ),
        ]));

        $errors->put("surname", $validator->validate($formInput["surname"], [
            new NotBlank(message: "Nazwisko jest wymagane"),
            new Length(
                min: 2, max: 50,
                minMessage: "Nazwisko musi mieć co najmniej 2 znaki",
                maxMessage: "Nazwisko może mieć maksymalnie 50 znaków"
            )
        ]));

        $errors->put("company", $validator->validate($formInput["company"], [
            new Length(
                max: 50, maxMessage: "Firma może mieć maksymalnie 50 znaków"
            )
        ]));

        return $errors->map(
            fn(ConstraintViolationList $violationList) => $violationList->count() > 0 ? $violationList->get(0)->getMessage() : null
        )->filter();
    }
}