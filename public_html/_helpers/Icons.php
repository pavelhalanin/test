<?php

class Icons {
    static function getDocumentIcon($file_path) {
        $file_extension = pathinfo("$file_path", PATHINFO_EXTENSION); // Получаем расширение

        $icon_class = "";
        $icon_color = "";
        switch ($file_extension) {
            case 'pdf':
                $icon_class = "bi-file-earmark-pdf";
                $icon_color = "red";
                break;

            case 'docx':
            case 'doc':
            case 'odt':
                $icon_class = "bi-file-earmark-word";
                $icon_color = "DodgerBlue";
                break;

            case 'xlsx':
            case 'xls':
            case 'ods':
                $icon_class = "bi-file-earmark-excel";
                $icon_color = "green";
                break;

            case 'pptx':
            case 'ppt':
            case 'odp':
                $icon_class = "bi-file-earmark-ppt";
                $icon_color = "DarkOrange";
                break;

            case 'png':
                $icon_class = "bi-file-earmark-image";
                $icon_color = "gray";
                break;

            default:
                $icon_class = "bi-file-earmark";
                $icon_color = "gray";
                break;
        }

        return "<i class=\"bi $icon_class\" style=\"font-size: 2em; color: $icon_color;\"></i>";
    }
}
