<?php

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

class FileManager extends Field
{
    /**
     * Blade template
     *
     * @var string
     */
    protected $view = 'platform::fields.filemanager';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class' => 'form-control',
        'title' => 'File Picker',
        'allowMultiple' => 0,
        'value' => [],
        'mimes' => [],
        'watermark' => 1,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'name',
    ];

    /**
     * @return $this
     */
    public function multiple(): self
    {
        $this->set('allowMultiple', 1);

        return $this;
    }

    /**
     * @return $this
     */
    public function noWatermark(): self
    {
        $this->set('watermark', 0);

        return $this;
    }
}
