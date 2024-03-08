<?php
namespace Blumilksoftware\Lmt;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransportFactory;
use Symfony\Component\Mime\Email;

class RegistrationEmailHandler
{
    private Mailer $mailer;
    private TemplateRenderer $templateRenderer;

    public function __construct() {
        $transport = (new EsmtpTransportFactory())->create(new Dsn(
            "smtp",
            $_ENV["SMTP_HOST"],
            $_ENV["SMTP_USERNAME"],
            $_ENV["SMTP_PASSWORD"],
            $_ENV["SMTP_PORT"]
        ));

        $this->mailer = new Mailer($transport);
        $this->templateRenderer = new TemplateRenderer();
    }

    /** @param array<string, string> $formInput */
    public function sendConfirmationEmail(array $formInput): void {
        $emailTemplate = $this->templateRenderer->render("email_registration_confirmation.html", [
            "name" => $formInput["name"],
            "surname" => $formInput["surname"],
        ]);

        $email = (new Email())
            ->from($_ENV["EMAIL_FROM"])
            ->to($formInput["email"])
            ->subject("LMT - Potwierdzenie rejestracji")
            ->html($emailTemplate);

        $this->mailer->send($email);
    }

    /** @param array<string, string> $formInput */
    public function sendRegistrationEmail(array $formInput): void {
        $email = $_ENV["REGISTRATION_NOTIFICATION_EMAIL"];

        $emailTemplate = $this->templateRenderer->render("email_registration_notice.txt", [
            "name" => $formInput["name"],
            "surname" => $formInput["surname"],
            "company" => $formInput["company"],
            "email" => $formInput["email"],
            "registration_date" => date("Y-m-d H:i:s"),
        ]);

        $email = (new Email())
            ->from($_ENV["EMAIL_FROM"])
            ->to($email)
            ->subject("LMT - nowa rejestracja")
            ->text($emailTemplate);

        $this->mailer->send($email);
    }
}