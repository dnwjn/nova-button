<?php

namespace Dnwjn\NovaButton;

use Dnwjn\NovaButton\Events\ButtonClick;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\SupportsDependentFields;
use Laravel\Nova\Fields\Unfillable;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class Button extends Field implements Unfillable
{
    use SupportsDependentFields;

    /** @var string */
    public $component = 'nova-button-field';

    /** @var bool */
    public $showOnUpdate = true;

    /** @var bool */
    public $showOnCreation = true;

    /** @var bool */
    public $showOnDetail = true;


    /** @var string|null */
    public $text = null;

    /** @var callable|string|null */
    public $key = null;

    /** @var array */
    public $config = [];

    /** @var string|null */
    public $style = null;

    /** @var string|null */
    public $loadingText = null;

    /** @var string|null */
    public $loadingStyle = null;

    /** @var string|null */
    public $successText = null;

    /** @var string|null */
    public $successStyle = null;

    /** @var string|null */
    public $errorText = null;

    /** @var string|null */
    public $errorStyle = null;

    /** @var array|null */
    public $confirm = null;

    /** @var bool */
    public $reload = false;

    /** @var bool */
    public $reloadHard = false;

    /** @var string */
    public $event = ButtonClick::class;

    /** @var mixed */
    public $eventArgs = null;

    /** @var string */
    public $emit = ButtonClick::class;

    /** @var mixed */
    public $emitArgs = null;

    /** @var bool */
    public $reset = false;

    /** @var bool */
    public $visible = true;

    /** @var bool */
    public $disabled = false;

    /** @var string|null */
    public $title = null;

    /** @var string|null */
    public $label = null;

    /** @var string|null */
    public $indexName = null;

    /** @var array */
    public $classes = [];

    /** @var string|null */
    public $type = null;

    /** @var array|null */
    public $route = null;

    /** @var array|null */
    public $link = null;

    /** @var string|null */
    public $indexAlign = 'left';

    /** @var string|null */
    public $loadingClasses = null;

    /** @var string|null */
    public $successClasses = null;

    /** @var string|null */
    public $errorClasses = null;

    /**
     * Create a new field.
     *
     * @param string $name
     * @param string|callable|null $attribute
     */
    public function __construct($name, $attribute = null)
    {
        parent::__construct($name, $attribute);

        $this->text = $name;
        $this->key = $attribute ?? Str::kebab($name);
        $this->config = config('nova-button');
        $this->indexName = $name;

        $this->addDefaultSettings();
    }

    /**
     * @return void
     */
    protected function addDefaultSettings(): void
    {
        $this->addLinkFallbacks();

        $this->style = Arr::get($this->config, 'defaults.style', 'link-primary');
        $this->loadingText = Arr::get($this->config, 'defaults.loadingText', 'Loading');
        $this->loadingStyle = Arr::get($this->config, 'defaults.loadingStyle', str_replace('primary', 'gray', $this->style));
        $this->errorText = Arr::get($this->config, 'defaults.errorText', 'Error!');
        $this->errorStyle = Arr::get($this->config, 'defaults.errorStyle', str_replace('primary', 'danger', $this->style));
        $this->successText = Arr::get($this->config, 'defaults.successText', 'Success!');
        $this->successStyle = Arr::get($this->config, 'defaults.successStyle', str_replace('primary', 'success', $this->style));

        $this->fillCallback = $this->getNullFillCallback();
    }

    /**
     * @return void
     */
    protected function addLinkFallbacks(): void
    {
        if (!Arr::has($this->config, 'styles.link-primary')) {
            $this->config['styles']['link-primary'] = 'shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900';
        }

        if (!Arr::has($this->config, 'styles.link-success')) {
            $this->config['styles']['link-success'] = 'cursor-pointer dim inline-block text-green-500 font-bold';
        }

        if (!Arr::has($this->config, 'styles.link-gray')) {
            $this->config['styles']['link-gray'] = 'cursor-pointer dim inline-block text-gray-500 font-bold';
        }

        if (!Arr::has($this->config, 'styles.link-danger')) {
            $this->config['styles']['link-danger'] = 'cursor-pointer dim inline-block text-yellow-500 font-bold';
        }
    }

    /**
     * Resolve the field's value.
     *
     * @param mixed $resource
     * @param string|null $attribute
     * @return void
     */
    public function resolve($resource, $attribute = null): void
    {
        parent::resolve($resource, $attribute);

        $this->classes[] = Arr::get($this->config, "styles.{$this->style}");
        $this->loadingClasses = Arr::get($this->config, "styles.{$this->loadingStyle}");
        $this->successClasses = Arr::get($this->config, "styles.{$this->successStyle}");
        $this->errorClasses = Arr::get($this->config, "styles.{$this->errorStyle}");

        $this->withMeta([
            'text' => $this->text,
            'key' => $this->key,
            'loadingText' => $this->loadingText,
            'successText' => $this->successText,
            'errorText' => $this->errorText,
            'confirm' => $this->confirm,
            'reload' => $this->reload,
            'reloadHard' => $this->reloadHard,
            'reset' => $this->reset,
            'event' => $this->event,
            'eventArgs' => $this->eventArgs,
            'emit' => $this->emit,
            'emitArgs' => $this->emitArgs,
            'visible' => $this->visible,
            'disabled' => $this->disabled,
            'title' => $this->title,
            'label' => $this->label,
            'indexName' => $this->indexName,
            'classes' => $this->classes,
            'type' => $this->type,
            'route' => $this->route,
            'link' => $this->link,
            'indexAlign' => $this->indexAlign,
            'loadingClasses' => $this->loadingClasses,
            'successClasses' => $this->successClasses,
            'errorClasses' => $this->errorClasses,
        ]);
    }

    //--------------------------------------
    // TYPES
    //--------------------------------------

    /**
     * Enable the confirmation button type.
     *
     * @param string|null $title
     * @param string|null $body
     * @param string|null $confirm
     * @param string|null $cancel
     * @return $this
     */
    public function confirm(?string $title = null, ?string $body = null, ?string $confirm = null, ?string $cancel = null): self
    {
        $this->confirm = [
            'title' => __('Confirmation'),
            'body' => null,
            'confirmButtonText' => $confirm ?: __('Confirm'),
            'cancelButtonText' => $cancel ?: __('Cancel'),
        ];

        if ($title !== null && $body === null) {
            $this->confirm['body'] = $title;
        }

        if ($title !== null && $body !== null) {
            $this->confirm['title'] = $title;
            $this->confirm['body'] = $body;
        }

        return $this;
    }

    /**
     * Enable the reload button type.
     *
     * @param bool $reload
     * @return $this
     */
    public function reload(bool $reload = true): self
    {
        $this->reload = $reload;

        return $this;
    }


    /**
     * Enable "hard" (window.reload, not inertia) reloads
     *
     * @param bool $value
     * @return $this
     */
    public function reloadHard(bool $value = true): self
    {
        if ($value)
            $this->reloadHard = $this->reload = $value;
        return $this;
    }

    /**
     * Enable the event button type.
     *
     * @param string $event
     * @param mixed $eventArgs
     * @return $this
     */
    public function event(string $event, mixed $eventArgs): self
    {
        $this->event = $event;
        $this->eventArgs = $eventArgs;

        return $this;
    }

    /**
     * Enable the emit button type.
     *
     * @param string $emit
     * @param mixed $emitArgs
     * @return $this
     */
    public function emit(string $emit, mixed $emitArgs): self
    {
        $this->emit = $emit;
        $this->emitArgs = $emitArgs;

        return $this;
    }

    /**
     * Reset the button to active after task completion.
     *
     * @param bool $value
     * @return $this
     */
    public function reset(bool $value = true): self
    {
        $this->reset = $value;

        return $this;
    }

    //--------------------------------------
    // CONDITIONALS
    //--------------------------------------

    /**
     * Set the button visibility.
     *
     * @param bool $condition
     * @return $this
     */
    public function visible(bool $condition): self
    {
        $this->visible = $condition;

        return $this;
    }

    /**
     * Set the button disabled state.
     *
     * @param bool $condition
     * @return $this
     */
    public function disabled(bool $condition = true): self
    {
        $this->disabled = $condition;

        return $this;
    }

    //--------------------------------------
    // TEXTS
    //--------------------------------------

    /**
     * Set the loading text.
     *
     * @param string $loadingText
     * @return $this
     */
    public function loadingText(string $loadingText): self
    {
        $this->loadingText = $loadingText;

        return $this;
    }

    /**
     * Set the success text.
     *
     * @param string $successText
     * @return $this
     */
    public function successText(string $successText): self
    {
        $this->successText = $successText;

        return $this;
    }

    /**
     * Set the error text.
     *
     * @param string $errorText
     * @return $this
     */
    public function errorText(string $errorText): self
    {
        $this->errorText = $errorText;

        return $this;
    }

    /**
     * Set the title.
     *
     * @param string $title
     * @return $this
     */
    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the label.
     *
     * @param string $label
     * @return $this
     */
    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Set the index name.
     *
     * @param string|null $indexName
     * @return $this
     */
    public function indexName(?string $indexName = null): self
    {
        $this->indexName = $indexName;

        return $this;
    }

    //--------------------------------------
    // STYLES
    //--------------------------------------

    /**
     * Set the classes.
     *
     * @param string|array $classes
     * @return $this
     */
    public function classes(mixed $classes): self
    {
        $this->classes = array_merge($this->classes, is_array($classes) ? $classes : explode(' ', $classes));

        return $this;
    }

    /**
     * Set the style.
     *
     * @param string $style
     * @return $this
     */
    public function style(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Set the loading style.
     *
     * @param string $loadingStyle
     * @return $this
     */
    public function loadingStyle(string $loadingStyle): self
    {
        $this->loadingStyle = $loadingStyle;

        return $this;
    }

    /**
     * Set the success style.
     *
     * @param string $successStyle
     * @return $this
     */
    public function successStyle(string $successStyle): self
    {
        $this->successStyle = $successStyle;

        return $this;
    }

    /**
     * Set the error style.
     *
     * @param string $errorStyle
     * @return $this
     */
    public function errorStyle(string $errorStyle): self
    {
        $this->errorStyle = $errorStyle;

        return $this;
    }

    //--------------------------------------
    // ROUTES
    //--------------------------------------

    /**
     * Set the index route.
     *
     * @param string $namespace
     * @return $this
     */
    public function index(string $namespace): self
    {
        $this->route('index', [
            'resourceName' => $this->normalizeResourceName($namespace),
        ]);

        return $this;
    }

    /**
     * Set the detail route.
     *
     * @param string $namespace
     * @param int $id
     * @return $this
     */
    public function detail(string $namespace, int $id): self
    {
        $this->route('detail', [
            'resourceName' => $this->normalizeResourceName($namespace),
            'resourceId' => $id,
        ]);

        return $this;
    }

    /**
     * Set the create route.
     *
     * @param string $namespace
     * @return $this
     */
    public function create(string $namespace): self
    {
        $this->route('create', [
            'resourceName' => $this->normalizeResourceName($namespace),
        ]);

        return $this;
    }

    /**
     * Set the edit route.
     *
     * @param string $namespace
     * @param int $id
     * @return $this
     */
    public function edit(string $namespace, int $id): self
    {
        $this->route('edit', [
            'resourceName' => $this->normalizeResourceName($namespace),
            'resourceId' => $id,
        ]);

        return $this;
    }

    /**
     * Set the lens route.
     *
     * @param string $namespace
     * @param string $key
     * @return $this
     */
    public function lens(string $namespace, string $key): self
    {
        $this->route('lens', [
            'resourceName' => $this->normalizeResourceName($namespace),
            'lens' => $key,
        ]);

        return $this;
    }

    /**
     * Set the link.
     *
     * @param string $href
     * @param string $target
     * @return $this
     */
    public function link(string $href, string $target = '_blank'): self
    {
        $this->type = 'link';
        $this->link = compact('href', 'target');

        return $this;
    }

    /**
     * Set the route.
     *
     * @param string $name
     * @param array $params
     * @return $this
     */
    protected function route(string $name, array $params = []): self
    {
        $this->type = 'route';
        $this->route = [
            'name' => $name,
            'params' => $params,
            'query' => [],
        ];

        return $this;
    }

    /**
     * Set the route params.
     *
     * @param array $params
     * @return $this
     */
    public function withParams(array $params): self
    {
        $this->route['query'] = array_merge($this->route['query'] ?? [], $params);

        return $this;
    }

    /**
     * Set the index filters.
     *
     * @param array $filters
     * @return $this
     */
    public function withFilters(array $filters): self
    {
        $resourceName = $this->route['params']['resourceName'] ?? null;

        if ($resourceName === null) {
            return $this;
        }

        $key = $resourceName . '_filter';

        $query = collect($filters)
            ->map(function ($value, $key) {
                return [
                    'class' => $key,
                    'value' => $value,
                ];
            })->values();

        $this->route['query'][$key] = base64_encode(json_encode($query));

        return $this;
    }

    /**
     * @param string $namespace
     * @return string
     */
    protected function normalizeResourceName(string $namespace): string
    {
        return class_exists($namespace) && is_subclass_of($namespace, Resource::class)
            ? $namespace::uriKey() : $namespace;
    }

    /**
     * As per https://stackoverflow.com/a/64378023/2549335
     *
     * @return callable
     */
    private function getNullFillCallback(): callable
    {
        return static function (NovaRequest $request, $model, $attribute, $requestAttribute) {
            return null;
        };
    }
}
