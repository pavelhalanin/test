<?php

class Sitemap {
    static function render() {
        ob_start(); // Запускаем буферизацию

        echo '<?xml version="1.0" encoding="UTF-8"?>';

        ?>

        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

        <?php

        $arr = [
            [
                'loc' => '/',
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ],
            [
                'loc' => '/about',
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ],
            [
                'loc' => '/prices',
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ],
            [
                'loc' => '/catalogs',
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ],
            [
                'loc' => '/certificates',
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ],
        ];

        for ($i = 0; $i < count($arr); $i++) {
            $pageData = $arr[$i];

            ?>

            <url>
                <loc><?= $pageData['loc'] ?></loc>
                <changefreq><?= $pageData['changefreq'] ?></changefreq>
                <priority><?= $pageData['priority'] ?></priority>
            </url>

            <?php

        }

        ?>

        </urlset>

        <?php

        $output = ob_get_clean(); // Получаем и очищаем буфер
        $output = preg_replace('/\s+/', ' ', $output); // Удаляем лишние пробелы
        $output = trim($output); // Удаляем пробелы в начале и конце строки

        header('Content-type: text/xml');
        echo $output;
        exit;
    }
}
