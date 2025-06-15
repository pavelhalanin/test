<?php

try {
    $HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['WWW_HOME'];

    include_once "$HOME/env.php";
    include_once "$HOME/_helpers/Ui.php";
    include_once "$HOME/_helpers/Icons.php";
    include_once "$HOME/_libs/github.com/erusev/parsedown/Parsedown.php";

    $url = $_SERVER['REQUEST_URI'];
    $path = parse_url($url, PHP_URL_PATH); // Получаем путь без параметров
    $urlSegment = basename($path); // Последний сегмент URL

    if (strlen($urlSegment) == 0) {
        $urlSegment = 'index';
    }

    $pdo = new PDO(
        $env['mysql_dns'],
        $env['mysql_user'],
        $env['mysql_pass'],
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT
                Articles.dp_id AS article_id,
                Articles.dp_name AS seo_title,
                Articles.dp_seoKeywords AS seo_keywords,
                Articles.dp_seoDescription AS seo_description,
                Articles.dp_text AS text,
                '_' AS '_'
            FROM
                DP_DOC_Articles AS Articles
            WHERE
                Articles.dp_urlSegment = :dp_urlSegment
            ";

    $sth = $pdo->prepare($sql);
    $sth->bindParam('dp_urlSegment', $urlSegment, PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);

    if (!$result) {

        ob_start(); // Запускаем буферизацию

        ?>

        <div class='container'>
            <h1 class="text-center text-primary">404</h1>
            <p>Что-то пошло не так...</p>
            <p>Добро пожаловать на страницу 404! Вы находитесь здесь, потому что ввели адрес страницы, которая уже не существует.</p>
            <p>Скорее всего, это случилось по одной из следующих причин:</p>
            <ul>
                <li>Страница удалена (из-за утраты актуальности информации);</li>
                <li>Страница перенесена в другое место;</li>
                <li>Возможно, при вводе адреса была пропущена какая-то буква (на самом деле, у нас самих так часто получается);</li>
                <li>Вам просто нравится изучать 404 страницы.</li>
            </ul>
        </div>

        <?php

        $output = ob_get_clean(); // Получаем и очищаем буфер
        $output = preg_replace('/\s+/', ' ', $output); // Удаляем лишние пробелы
        $output = trim($output); // Удаляем пробелы в начале и конце строки

        echo Ui::getHead([
            'SEO_TITLE' => '404',
            'SEO_DESCRIPTION' => '404',
            'SEO_KEYWORDS' => '404',
            'children' => $output,
        ]);

        exit;
    }

    $SEO_TITLE = $result['seo_title'];
    $SEO_DESCRIPTION = $result['seo_description'];
    $SEO_KEYWORDS = $result['seo_keywords'];
    $text = $result['text'];
    $text = str_replace('\n', "\n", $text);

    $parsedown = new Parsedown();
    $markdown = $text;
    $html = $parsedown->text($markdown);

    $sql = "SELECT
                ArticleAttachedLinks.dp_name AS file_name,
                ArticleAttachedLinks.dp_url AS file_url,
                '_' AS '_'
            FROM
                DP_LST_ArticleAttachedLinks AS ArticleAttachedLinks
            WHERE
                ArticleAttachedLinks.dp_articleId = :articleId
            ";

    $sth = $pdo->prepare($sql);
    $sth->bindParam('articleId', $result['article_id'], PDO::PARAM_STR);
    $sth->execute();
    $files = $sth->fetchAll(PDO::FETCH_ASSOC);

    ob_start(); // Запускаем буферизацию

    ?>

    <style>
        h1 {
            text-align: center;
            color: #0066cc;
        }

        .markdown_text img {
            max-width: 480px;
            float: left;
            margin: 16px;
            width: 100%;
        }

        .markdown_text ul {
            display: block;
            overflow: hidden;
            position: relative;
        }

        @media (max-width: 1000px) {
            .markdown_text img {
                width: 100%;
                max-width: 1000px;
                text-align: center;
                margin: 0 auto;
            }
        }
    </style>

    <div class='container'>
        <div class="markdown_text">
            <h1><?= strcmp($urlSegment, 'index') == 0 ? '' : $SEO_TITLE ?></h1>
            <p><?= $html ?></p>
            
            <?php

            if (count($files) > 0) {

                ?>

                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <td class="text-center">Наименование файла</td>
                            <td class="text-center" width="80">Файл</td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        for ($i = 0; $i < count($files); $i++) {
                            $fileData = $files[$i];

                            ?>

                            <tr>
                                <td class="align-middle">
                                    <?= $fileData['file_name'] ?>
                                </td>
                                <td class="text-center">
                                    <a target="_blank" href="<?= $fileData['file_url'] ?>">
                                        <?= Icons::getDocumentIcon($fileData['file_url']) ?>
                                    </a>
                                </td>
                            </tr>

                            <?php

                        }

                        ?>

                    </tbody>
                </table>

                <?php

            }

            ?>

        </div>
    </div>

    <?php

    $output = ob_get_clean(); // Получаем и очищаем буфер
    $output = preg_replace('/\s+/', ' ', $output); // Удаляем лишние пробелы
    $output = trim($output); // Удаляем пробелы в начале и конце строки

    echo Ui::getHead([
        'SEO_TITLE' => $SEO_TITLE,
        'SEO_DESCRIPTION' => $SEO_DESCRIPTION,
        'SEO_KEYWORDS' => $SEO_KEYWORDS,
        'children' => $output,
    ]);
}
catch(Throwable $exception) {
    echo "<details><summary>Произошла ошибка</summary><pre>";
    print_r($exception);
    echo "</pre></details>";
}
