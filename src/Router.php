<?php

namespace App;

class Router
{
    private $viewPath;
    private $router;

    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();
    }

    public function get(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    public function post(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('POST', $url, $view, $name);
        return $this;
    }

    public function match(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('POST|GET', $url, $view, $name);
        return $this;
    }

    public function url(string $name, array $params = [])
    {
        return $this->router->generate($name, $params);
    }

    public function Name(string $name)
    {
        return $name;
    }

    public function run(): self
    {
        $match = $this->router->match();
        if (!$match) {
            // Gestion des erreurs de route
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
            include $this->viewPath . DIRECTORY_SEPARATOR . 'auth/404.php';
            return $this;
        }

        $name = $match['name'];
        $view = $match['target'];
        $params = $match['params'];

        // Extraire les paramètres de requête
        $queryParams = [];
        parse_str($_SERVER['QUERY_STRING'], $queryParams);

        // Fusionner les paramètres de route et de requête
        $params = array_merge($params, $queryParams);

        // Définir le routeur comme variable globale
        global $router;
        $router = $this;

        ob_start();
        require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        $content = ob_get_clean();

        if (str_contains($name, '_auth')) {
            require $this->viewPath . DIRECTORY_SEPARATOR . 'layouts/login.php';
        } elseif (str_contains($name, '_sans')) {
            require $this->viewPath . DIRECTORY_SEPARATOR . 'layouts/default2.php';
        } else {
            require $this->viewPath . DIRECTORY_SEPARATOR . 'layouts/default.php';
        }

        return $this;
    }
}
