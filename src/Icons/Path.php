<?php

declare(strict_types=1);

namespace Orchid\Icons;

class Path
{
    /**
     * @return string
     */
    public static function getFolder(): string
    {
        return realpath(__DIR__ . '/../../resources/icons');
    }
}