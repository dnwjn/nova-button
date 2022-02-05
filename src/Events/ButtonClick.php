<?php

namespace Dnwjn\NovaButton\Events;

use Illuminate\Foundation\Events\Dispatchable;

class ButtonClick
{
    use Dispatchable;

    /** @var string */
    public $resource;

    /** @var string */
    public $key;

    public function __construct(string $resource, string $key)
    {
        $this->resource = $resource;
        $this->key = $key;
    }
}
