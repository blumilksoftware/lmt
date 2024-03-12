<?php
namespace Blumilksoftware\Lmt;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TemplateRenderer
{
    private Environment $twig;

    public function __construct() {
        $prod = $_ENV["ENVIRONMENT"] === "prod";
        $loader = new FilesystemLoader(__DIR__ . "/templates");
        $this->twig = new Environment($loader, [
            "cache" => __DIR__ . "/../cache/",
            "auto_reload" => !$prod
        ]);
    }

    public function render(string $templateName, array $arguments = []): string {
        return $this->twig->render($templateName, $arguments);
    }
}
