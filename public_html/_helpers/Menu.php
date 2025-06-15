<?php

class Menu {
    static function getHtml($params = []) {
        ob_start(); // Запускаем буферизацию

        ?>

        <div style="display: flex; flex-direction: column; height: 100%;">
            <div style="flex: 1 0 auto;">
                <nav class="navbar navbar-light bg-light fixed-top">
                    <div class="row" style="width: 100%;">
                        <div class="col-3"></div>
                        <div class="col-6 text-center">
                            <a class="navbar-brand" href="/">
                                <img src="/images/logo.png" style="height: 48px;" alt="">
                            </a>
                        </div>
                        <div class="col-3 d-flex justify-content-end align-items-center">
                            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </div>
                    </div>

                    <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="offcanvasDarkNavbar"
                        aria-labelledby="offcanvasLightNavbarLabel">
                    <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">ООО "ДЕ-ПА"</h5>
                            <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                                <?php

                                $menu = [
                                    [
                                        'name' => 'Главная',
                                        'url' => '/',
                                    ],
                                    [
                                        'name' => 'О нас',
                                        'url' => '/about/',
                                    ],
                                    [
                                        'name' => 'Продукты',
                                        'url' => '/products/',
                                    ],
                                    [
                                        'name' => 'Прайсы',
                                        'url' => '/prices/',
                                    ],
                                    [
                                        'name' => 'Каталоги',
                                        'url' => '/catalogs/',
                                    ],
                                    [
                                        'name' => 'Сертификаты',
                                        'url' => '/certificates/',
                                    ],
                                    [
                                        'name' => 'Услуги',
                                        'url' => 'https://consulting.de-pa.by/',
                                    ],
                                    [
                                        'name' => 'Контакты',
                                        'url' => '/contacts/',
                                    ],
                                ];

                                $uri = $_SERVER['REQUEST_URI'];
                                for ($i = 0; $i < count($menu); $i++) {
                                    $menu[$i]['isActive'] = false;
                                    if (strcmp($menu[$i]['url'], $uri) == 0) {
                                        $menu[$i]['isActive'] = true;
                                    }
                                }

                                for ($i = 0; $i < count($menu); $i++) {
                                    $element = $menu[$i];

                                    ?>

                                    <li class="nav-item">
                                        <a
                                            class="nav-link <?=$element['isActive'] ? 'active' : '' ?>"
                                            aria-current="page"
                                            href="<?=$element['url']?>"
                                        >
                                            <?=$element['name']?>
                                        </a>
                                    </li>

                                    <?php

                                }

                                ?>

                            </ul>
                        </div>
                    </div>
                </nav>
                <div style="height: 64px;"></div>
                <?= $params['children'] ?>
            </div>
            <div style="flex: 0 0 auto;" class="bg-dark text-light">
               <?= Menu::echoFooter() ?>
            </div>
        </div>

        <?php

        $output = ob_get_clean(); // Получаем и очищаем буфер
        $output = preg_replace('/\s+/', ' ', $output); // Удаляем лишние пробелы
        $output = trim($output); // Удаляем пробелы в начале и конце строки

        return $output;
    }

    static function echoFooter() {

        ?>

        <div class="container mt-3 mb-2">
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <p>Общество с ограниченной ответственностью "ДЕ-ПА"</p>
                    <p>УНП 291477952</p>
                    <p>Республика Беларусь, 224701, Брестская обл., г. Брест, ул. Лейтенанта Рябцева, дом №108М</p>
                    <p>Свидетельство о государственной регистрации от <abbr title="2017-06-14">14 июня 2017 г.</abbr>, выдано Администрацией Ленинского района г. Бреста</p>
                    <p>Регистрация в БелГИЭ от <abbr title="2019-05-14 16:55:25">14 мая 2019 г.</abbr></p>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <p>Режим работы: 08:00 - 17:00 (выходной сб, вс)</p>
                    <p>
                        <a class="btn btn-primary d-block" href="tel:+375162517733">+375-162-51-77-33</a>
                    </p>
                    <p>
                        <a class="btn btn-primary d-block" href="mailto:info@de-pa.by">info@de-pa.by</a>
                    </p>
                    <p>
                        Павел Галанин © 2017-2025
                    </p>
                </div>
            </div>
        </div>

        <?php

    }
}
