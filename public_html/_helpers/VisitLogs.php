<?php

$HOME = strlen($_SERVER['DOCUMENT_ROOT']) != 0 ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['WWW_HOME'];

include_once "$HOME/env.php";

class VisitLogs {
    static function saveLogOnDatabase() {
        global $env;

        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $url = 
            (isset($_SERVER['HTTPS']) ? 'https://' : 'http://')
            . $_SERVER['HTTP_HOST']
            . $_SERVER['REQUEST_URI'];

        $pdo = new PDO(
            $env['mysql_dns'],
            $env['mysql_user'],
            $env['mysql_pass'],
        );

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO
                    PH__DOC__visit_logs
                    (ip, url, client)
                VALUES
                    (:ip, :url, :client)
                ";

        $sth = $pdo->prepare($sql);
        $sth->bindParam('ip', $ip, PDO::PARAM_STR);
        $sth->bindParam('url', $url, PDO::PARAM_STR);
        $sth->bindParam('client', $client, PDO::PARAM_STR);
        $sth->execute();
    }
}
