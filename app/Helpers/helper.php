<?php

function basePath(): string
{
    return dirname(__DIR__,2);
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}
