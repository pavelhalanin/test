<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['WWW_HOME'];

include_once "$HOME/env.php";

class Documents {
    static function getHtml() {
        global $env;

        $uri = $_SERVER['REQUEST_URI'];
        $uri = preg_replace('/', '', $uri);

        $pdo = new PDO(
            $env['mysql_dns'],
            $env['mysql_user'],
            $env['mysql_pass'],
        );

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT
                    *
                FROM
                    DP_DOC_Articles
                ";

        $sth = $pdo->prepare($sql);
        $sth->bindParam('dp_urlSegment', $uri, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetch();

        if ($result) {
            $articleId = $result['dp_id'];

            $sql = "SELECT
                        *
                    FROM
                        DP_LST_ArticleAttachedLinks
                    WHERE
                        dp_articleId = :articleId
                    ";

            $sth = $pdo->prepare($sql);
            $sth->bindParam('articleId', $articleId, PDO::PARAM_STR);
            $sth->execute();
            $documents = $sth->fetchAll();

            ob_start(); // Запускаем буферизацию

            ?>

            <table>
                <thead>
                    <tr>
                        <td>Наименование</td>
                        <td>Файл</td>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    for ($i = 0; $i < count($documents); $i++) {
                        $document = $documents[$i];

                        ?>

                        <tr>
                            <td><?= $document['dp_name'] ?></td>
                            <td>
                                <a href="<?= $document['dp_url'] ?>">x</a>
                            </td>
                        </tr>

                        <?php

                    }

                    ?>

                </tbody>
            </table>

            <?php

            $output = ob_get_clean(); // Получаем и очищаем буфер
            $output = preg_replace('/\s+/', ' ', $output); // Удаляем лишние пробелы
            $output = trim($output); // Удаляем пробелы в начале и конце строки
        }

        return '';
    }
}
