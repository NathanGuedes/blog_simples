<?php

use JetBrains\PhpStorm\NoReturn;

function basePath(): string
{
    return dirname(__DIR__, 2);
}

#[NoReturn]
function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}


function getImageBase64(string $inputName): ?string
{
    //Verifica se o campo existe e se um arquivo foi realmente enviado.
    if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    $file = $_FILES[$inputName];
    $errorCode = $file['error'];

    //Verifica se houve algum erro no upload.
    if ($errorCode !== UPLOAD_ERR_OK) {
        throw new RuntimeException(getUploadErrorMessage($errorCode));
    }

    //Lê o conteúdo do arquivo temporário.
    $content = @file_get_contents($file['tmp_name']);

    if ($content === false) {
        throw new RuntimeException('Não foi possível ler o arquivo enviado.');
    }

    return base64_encode($content);
}

function getUploadErrorMessage(int $errorCode): string
{
    return match ($errorCode) {
        UPLOAD_ERR_INI_SIZE => 'O arquivo excede o tamanho máximo definido no servidor (upload_max_filesize).',
        UPLOAD_ERR_FORM_SIZE => 'O arquivo excede o tamanho máximo definido no formulário (MAX_FILE_SIZE).',
        UPLOAD_ERR_PARTIAL => 'O upload do arquivo foi feito parcialmente.',
        UPLOAD_ERR_NO_TMP_DIR => 'Nenhum diretório temporário foi encontrado.',
        UPLOAD_ERR_CANT_WRITE => 'Falha ao escrever o arquivo no disco.',
        UPLOAD_ERR_EXTENSION => 'Uma extensão do PHP impediu o upload do arquivo.',
        default => 'Ocorreu um erro desconhecido no upload.',
    };
}

