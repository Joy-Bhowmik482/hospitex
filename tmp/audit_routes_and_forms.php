<?php
$base = __DIR__ . '/../';
chdir($base);

$routesJson = null;
exec('php artisan route:list --json --no-ansi', $routesOutput, $code);
if ($code !== 0) {
    echo "ERROR: could not list routes\n";
    exit(1);
}
$routesJson = implode("\n", $routesOutput);
$routes = json_decode($routesJson, true);
if (!is_array($routes)) {
    echo "ERROR: route list JSON parse failed\n";
    exit(1);
}
$valid = [];
foreach ($routes as $route) {
    if (!empty($route['name'])) {
        $valid[$route['name']] = true;
    }
}

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator('app')) as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }
    $content = file_get_contents($file->getRealPath());
    preg_match_all('/route\(\s*["\']([^"\']+)["\']/', $content, $matches);
    foreach ($matches[1] as $name) {
        if (!isset($valid[$name]) && !preg_match('/^(http|\/|\:)/', $name)) {
            echo "INVALID_ROUTE_REF {$file->getRealPath()} -> {$name}\n";
        }
    }
}

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator('resources/views')) as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }
    $content = file_get_contents($file->getRealPath());
    preg_match_all('/route\(\s*["\']([^"\']+)["\']/', $content, $matches);
    foreach ($matches[1] as $name) {
        if (!isset($valid[$name]) && !preg_match('/^(http|\/|\:)/', $name)) {
            echo "INVALID_ROUTE_REF {$file->getRealPath()} -> {$name}\n";
        }
    }
    if (preg_match('/route\([^)]*\.store/i', $content) && !preg_match('/@csrf/i', $content)) {
        echo "MISSING_CSRF {$file->getRealPath()}\n";
    }
    if (preg_match('/route\([^)]*\.update/i', $content) && !preg_match('/@method\(\s*["\']?(PUT|PATCH)["\']?\s*\)/i', $content)) {
        echo "MISSING_METHOD_UPDATE {$file->getRealPath()}\n";
    }
    if (preg_match('/route\([^)]*\.destroy/i', $content) && (!preg_match('/@csrf/i', $content) || !preg_match('/@method\(\s*["\']?DELETE["\']?\s*\)/i', $content))) {
        echo "MISSING_METHOD_DELETE {$file->getRealPath()}\n";
    }
}
