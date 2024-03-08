<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Blumilksoftware\Lmt\FormValidator;
use Blumilksoftware\Lmt\RegistrationEmailHandler;
use Blumilksoftware\Lmt\TemplateRenderer;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__."/../.env");

$formInput = [
    "email" => trim($_POST["email"]) ?? "",
    "name" => strip_tags(trim($_POST["name"])) ?? "",
    "surname" => strip_tags(trim($_POST["surname"])) ?? "",
    "company" => strip_tags(trim($_POST["company"])) ?? "",
];

$errors = FormValidator::validateRegistrationFormInput($formInput);

$view = new TemplateRenderer();

if($errors->count() > 0) {
    header("HX-Retarget: #registration-errors");
    echo $view->render("registration_form_errors.html", [
        "errors" => $errors->toArray(),
        "formInput" => $formInput
    ]);
    return;
}

$mailer = new RegistrationEmailHandler();
$mailer->sendConfirmationEmail($formInput);
$mailer->sendRegistrationEmail($formInput);

echo $view->render("registration_form_success.html");
