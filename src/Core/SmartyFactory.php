<?php

declare(strict_types=1);

namespace App\Core;

class SmartyFactory
{
    public static function create(): \Smarty
    {
        $smarty = new \Smarty();
        $smarty->setTemplateDir(ROOT_DIR . '/templates');
        $smarty->setCompileDir(ROOT_DIR . '/storage/smarty/compile');
        $smarty->setCacheDir(ROOT_DIR . '/storage/smarty/cache');
        $smarty->caching = false;

        $smarty->registerPlugin('modifier', 'format_date', static function (string $dateStr, string $format = 'd.m.Y'): string {
            return date($format, strtotime($dateStr));
        });

        return $smarty;
    }
}
