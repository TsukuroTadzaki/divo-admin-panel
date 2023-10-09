<?php

namespace Orchid\Translate;

class Language
{
    public const TABLE = 'languages';

    protected $fillable = [
        'name',
        'slug',
        'status',
        'image',
    ];

    protected $name;

    protected $slug;

    protected $status;

    protected $image;
}
