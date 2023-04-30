<?php
namespace UmitYatarkalkmaz;
class Route
{
    private static bool $test = true;
    private static array $patterns = [':id' => '([0-9]+)', ':url' => '([0-9a-zA-Z-_]+)'];

    private static array $routes = ['get' => [], 'post' => []];
    private static string $prefix = '';
    private static bool $hasRoute = false;
    private static string $controllerPath = '/app/controller/';

    public static function prefix($prefix): self
    {
        self::$prefix = $prefix;
        return new self();
    }

    public static function group(\Closure $closure): void
    {
        $closure();
        self::$prefix = '';
    }

    public static function get(string $path, $callback): self
    {
        $path = self::applyPrefix($path);
        self::$routes['get'][$path] = $callback;
        return new self;
    }

    private static function applyPrefix(string $path): string
    {
        $path = self::$prefix . $path;
        return self::clearURL($path);
    }

    private static function clearURL($url): string
    {
        $url = $url === '/' ? $url : rtrim($url, '/');
        return $url;
    }

    public static function post(string $path, $callback): void
    {
        $path = self::applyPrefix($path);
        self::$routes['post'][$path] = $callback;
    }

    public static function dispatch(): void
    {
        $url = self::getUrl();
        $method = self::getMethod();

        foreach (self::$routes[$method] as $path => $callback) {
            foreach (self::$patterns as $key => $pattern) {
                $path = str_replace($key, $pattern, $path);
            }

            $pattern = '@^' . $path . '$@';
            if (preg_match($pattern, $url, $params)) {

                array_shift($params);

                self::$hasRoute = true;

                if (is_callable($callback)) {
                    call_user_func_array($callback, $params);
                } elseif (is_string($callback)) {
                    [$controllerName, $methodName] = explode('@', $callback);
                    $controllerName = explode('/', $controllerName);
                    $controllerName = end($controllerName);
                    $controllerFile = self::$controllerPath . strtolower($controllerName) . '.php';

                    require_once $controllerFile;

                    $controller = new $controllerName;
                    call_user_func_array([$controller, $methodName], $params);
                }
            }
        }

        self::handleNoRoute();
    }

    private static function getUrl(): string
    {
        $url = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);
        return self::clearURL($url);
    }

    private static function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    private static function handleNoRoute($controllerEnable = true): void
    {
        if (!self::$hasRoute) {
            if (self::$test) {
                echo self::getUrl();
            } else {
                if ($controllerEnable){
                    header('location:/404');
                }else{
                    http_response_code(404);
                    echo '404 NOT FOUND';
                    exit();
                }
            }
        }
    }

    public function where($key, $pattern): void
    {
        self::$patterns[':' . $key] = '(' . $pattern . ')';
    }
}
