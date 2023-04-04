<?php

namespace Dnwjn\NovaButton;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Unfillable;
use Laravel\Nova\Http\Requests\NovaRequest;

class ButtonGroup extends Field implements Unfillable
{
    /** @var string */
    public $component = 'nova-button-group-field';

    public $showOnCreation = true;
    public $showOnUpdate = true;
    public $showOnIndex = false;
    public $showOnDetail = true;

    /**
     * The Buttons in the ButtonGroup.
     *
     * @var array|\Illuminate\Support\Collection
     */
    public \Illuminate\Support\Collection|array $buttons;

    /**
     * Create a new ButtonGroup field.
     *
     * @param  string  $name
     * @param  string|array<int, class-string<\Laravel\Nova\Fields\Field>|callable>|null  $attribute
     * @param  array<int, class-string<\Laravel\Nova\Fields\Field>|callable>  $buttons
     * @return void
     */
    public function __construct($name, $attribute = null, $buttons = [])
    {
        if (is_array($attribute)) {
            $buttons = $attribute;
            $attribute = null;
        }

        parent::__construct($name, $attribute);

        $this->buttons = $buttons;
    }

    /**
     * Resolve the field's value for display.
     *
     * @param  mixed  $resource
     * @param  string|null  $attribute
     * @return void
     */
    public function resolveForDisplay($resource, $attribute = null)
    {
        $this->prepareButtons($resource, $attribute);
    }

    public function resolve($resource, $attribute = null): void {
        parent::resolve($resource, $attribute);
        $this->resolveForDisplay($resource, $attribute);
    }

    /**
     * Prepare the stack for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'buttons' => $this->buttons,
        ]);
    }

    /**
     * Prepare each button for serialization.
     *
     * @param  mixed  $resource
     * @param  string  $attribute
     * @return void
     */
    public function prepareButtons($resource, $attribute = null)
    {
        // Lets nop it all
        foreach ($this->buttons as $button) {
            $button->resolve($resource, $attribute);
        }
        return;

        $this->ensureButtonsAreResolveable();

        $request = app(NovaRequest::class);

        $this->buttons = $this->buttons->filter(function ($field) use ($request, $resource) {
            return true;
            // Lets just NOP this for now also
            // if ($request->isResourceIndexRequest()) {
            //     return $field->isShownOnIndex($request, $resource);
            // }
            //
            // return $field->isShownOnDetail($request, $resource);
        })->values()->each->resolveForDisplay($resource, $attribute);
    }

    /**
     * Ensure that each button for the field is resolvable.
     *
     * @return void
     */
    protected function ensureButtonsAreResolveable()
    {
        $this->buttons = collect($this->buttons)->map(function ($button) {
            // I think we can just get away with nulling this

            // if (is_callable($button)) {
            //     return GroupedButton::make('Anonymous', $button);
            // }

            return $button;
        });
    }
}
