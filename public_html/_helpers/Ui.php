<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['WWW_HOME'];

include_once "$HOME/_helpers/Menu.php";

class Ui {
    static function getHead($params = []) {
        $SEO_TITLE = isset($params['SEO_TITLE']) ? $params['SEO_TITLE'] : '-';
        $SEO_DESCRIPTION = isset($params['SEO_DESCRIPTION']) ? $params['SEO_DESCRIPTION'] : '-';
        $SEO_KEYWORDS = isset($params['SEO_KEYWORDS']) ? $params['SEO_KEYWORDS'] : '-';

        ob_start(); // Запускаем буферизацию

        ?>

        <!DOCTYPE html>
        <html lang="ru" style="height: 100%;">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title><?= $SEO_TITLE ?></title>
            <meta name="description" content="<?= $SEO_DESCRIPTION ?>" />
            <meta name="content" content="<?= $SEO_KEYWORDS ?>" />
            <link rel="stylesheet" href="/assets/npm/node_modules/bootstrap/dist/css/bootstrap.min.css" />
            <link rel="stylesheet" href="/assets/npm/node_modules/bootstrap-icons/font/bootstrap-icons.min.css" />
            <script src="/assets/npm/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        </head>
        <body style="height: 100%;">

        <?php

        echo Menu::getHtml([
            'children' => $params['children'],
        ]);

        $output = ob_get_clean(); // Получаем и очищаем буфер
        $output = preg_replace('/\s+/', ' ', $output); // Удаляем лишние пробелы
        $output = trim($output); // Удаляем пробелы в начале и конце строки

        return $output;
    }
}
