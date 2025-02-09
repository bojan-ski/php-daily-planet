<?php

declare(strict_types=1);

// LOAD PATH
function basePath(string $path = ''): string
{
    return __DIR__ . '../../' . $path;
}

// LOAD VIEW
function loadView(string $name, $data = []): void
{
    (string) $viewPath = basePath("App/views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "View '{$name}' not found!";
    }
}

// LOAD PARTIAL
function loadPartial(string $name, $data = []): void
{
    (string) $partialPath = basePath("App/views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        extract($data);
        require $partialPath;
    } else {
        echo "Partial '{$name}' not found!";
    }
}

// REDIRECT USER
function redirectUser(string $url): void
{
    header("Location: {$url}");
    exit();
}

// INSPECT DATA
function inspect(mixed $value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

// INSPECT DATA AND END PROGRAM
function inspectAndDie(mixed $value): void
{
    echo "<pre>";
    die(var_dump($value));
    echo "</pre>";
}
