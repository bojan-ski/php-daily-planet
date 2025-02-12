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
    // inspect($data);
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
    // inspect($data);
    (string) $partialPath = basePath("App/views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        extract($data);
        require $partialPath;
    } else {
        echo "Partial '{$name}' not found!";
    }
}

// CHECK DISPLAYED CONTENT
function checkContent(string $content): string
{
    return !empty(trim($content)) ? htmlspecialchars($content) : '';
};

// CHECK FORM DATA - is string
function isString(string $formData, int $min, int $max): bool
{
    if(!empty($formData) && is_string($formData)){
        $formDataValue = filter_var(trim($formData), FILTER_SANITIZE_SPECIAL_CHARS);
        $formDataLength = strlen($formDataValue);

        // inspect($formDataLength);

        return $formDataLength >= $min && $formDataLength <= $max;
    }

    return false;
};

// CHECK FORM DATA - is email
function isEmail(string $formData): bool
{
    if(!empty($formData) && is_string($formData)){
        $formDataValue = trim($formData);
        $isFormDataEmail = filter_var($formDataValue, FILTER_VALIDATE_EMAIL);
        $formDataLength = strlen($isFormDataEmail);

        return $formDataLength >= 8 && $formDataLength <= 40;
    }

    return false;
};

// CHECK FORM DATA - does match
function doesMatch(string $formDataOne, string $formDataTwo): bool
{
    if(!empty($formDataOne) && !empty($formDataTwo)){
        $formDataValueOne = trim($formDataOne);
        $formDataValueTwo = trim($formDataTwo);
    
        return $formDataValueOne == $formDataValueTwo;
    }

    return false;
};

// FORMAT DATE
function formateDate(string $date): string{
    return date("d.m.Y", strtotime($date));
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
