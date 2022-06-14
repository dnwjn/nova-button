<?php

namespace Dnwjn\NovaButton\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;

class ButtonClick
{
    use Dispatchable;

    /** @var string */
    public $key;

    /** @var Model|null */
    public $resource;

    public function __construct(string $key, $resource = null)
    {
        $this->key = $key;
        $this->resource = $resource;
    }
}
