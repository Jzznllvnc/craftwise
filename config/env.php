<?php

function loadEnv(?string $path = null): void
{
    $paths = $path !== null
        ? [$path]
        : [BASE_PATH . '.env', dirname(BASE_PATH) . DIRECTORY_SEPARATOR . '.env'];

    $envPath = null;

    foreach ($paths as $candidatePath) {
        if (isPathAllowedByOpenBaseDir($candidatePath) && is_readable($candidatePath)) {
            $envPath = $candidatePath;
            break;
        }
    }

    if ($envPath === null) {
        return;
    }

    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === '' || strpos($line, '#') === 0 || strpos($line, '=') === false) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        if ($key === '') {
            continue;
        }

        $firstChar = substr($value, 0, 1);
        $lastChar = substr($value, -1);

        if (($firstChar === '"' && $lastChar === '"') || ($firstChar === "'" && $lastChar === "'")) {
            $value = substr($value, 1, -1);
        }

        if (getenv($key) === false) {
            putenv($key . '=' . $value);
        }

        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

function isPathAllowedByOpenBaseDir(string $path): bool
{
    $openBaseDir = ini_get('open_basedir');

    if ($openBaseDir === false || trim($openBaseDir) === '') {
        return true;
    }

    $normalizedPath = normalizePathForOpenBaseDir($path);
    $directories = explode(PATH_SEPARATOR, $openBaseDir);

    foreach ($directories as $directory) {
        $directory = trim($directory);

        if ($directory === '') {
            continue;
        }

        if ($directory === '.') {
            $directory = getcwd() ?: $directory;
        }

        $normalizedDirectory = normalizePathForOpenBaseDir($directory);

        if ($normalizedPath === $normalizedDirectory || strpos($normalizedPath, $normalizedDirectory . DIRECTORY_SEPARATOR) === 0) {
            return true;
        }
    }

    return false;
}

function normalizePathForOpenBaseDir(string $path): string
{
    $realPath = realpath($path);
    $path = $realPath !== false ? $realPath : $path;

    return rtrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
}

function env(string $key, $default = null)
{
    if (array_key_exists($key, $_ENV)) {
        return $_ENV[$key];
    }

    if (array_key_exists($key, $_SERVER)) {
        return $_SERVER[$key];
    }

    $value = getenv($key);
    return $value === false ? $default : $value;
}
