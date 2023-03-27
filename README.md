# Nova Button

[![Latest Version on Github](https://img.shields.io/github/release/dnwjn/nova-button.svg?style=for-the-badge)](https://github.com/dnwjn/nova-button/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/dnwjn/nova-button.svg?style=for-the-badge)](https://packagist.org/packages/dnwjn/nova-button)
[![Github issues](https://img.shields.io/github/issues/dnwjn/nova-button?style=for-the-badge)](https://github.com/dnwjn/nova-button/issues)
[![License](https://img.shields.io/github/license/dnwjn/nova-button?style=for-the-badge)](https://github.com/dnwjn/nova-button/blob/main/LICENSE)

A Nova package for rendering buttons on index, detail and lens views.

Use buttons to trigger backend events, navigate Nova routes or visit links.

![example-users](https://user-images.githubusercontent.com/57711725/152637226-e7047831-b726-4940-95c9-617db4d42de4.png)

> **This package is a continuation of [dillingham/nova-button](https://github.com/dillingham/nova-button).**
> 
> I created this fork because the original package seemed abandoned (last release on 16-09-2020 at the time of writing)
> and for me it was too useful to leave unmaintained. I also noticed that there still was activity in the issues and pull requests,
> which I didn't want to be left ignored.
> 
> *This package remains open source, so I encourage everyone to keep contributing! And if you want to get in touch with me,*
> *feel free to do so!*

## Versions

For Nova 4 certain changes had to be made that rendered the package not backwards compatible with Nova 3. For that reason
the package was split up into multiple versions. Please see the table below to determine which version you need.

| Version                                            | Nova |
|----------------------------------------------------|------|
| v4 (current)                                       | 4.0  |
| [v3](https://github.com/dnwjn/nova-button/tree/v3) | 3.0  |

**Please note:** the `main` branch will always be the latest major version.

## Requirements

| What    | Version |
|---------|---------|
| PHP     | \>=7.3  |
| Laravel | \>=8.0  |
| Nova    | \>=4.0  |

## Installation

You can install this package by running the following command:

```bash
composer require dnwjn/nova-button:^4.0
```

To publish the config file, run the following command:

```bash
php artisan vendor:publish --tag="nova-button-config"
```

## Usage

```php
use Dnwjn\NovaButton\Button;
```

```php
public function fields(Request $request)
{
    return [
        ID::make('ID', 'id')->sortable(),
        Text::make('Name', 'name'),
        Button::make('Notify'),
    ];
}
```

### Quick links

* [Confirm](#confirm)
* [Reload](#reload)
* [Laravel Events](#laravel-events)
* [JavaScript Events](#javascript-events)
* [Texts](#texts)
* [State](#state)
* [Feedback](#feedback)
* [Nova routes](#nova-routes)
* [Links](#links)
* [Classes](#classes)
* [Styles](#styles)
* [Examples](#examples)

---

### Confirm

You can require a confirmation for destructive actions:

```php
Button::make('Cancel Account')->confirm('Are you sure?'),
Button::make('Cancel Account')->confirm('Confirmation', 'Are you sure you want to cancel your account?'),
Button::make('Cancel Account')->confirm('Confirmation', 'Are you sure you want to cancel your account?', 'Cancel'),
```

### Reload

You can reload the page after all events have finished.

```php
Button::make('Notify')->reload()
```
If you click multiple buttons, reloading will wait for all buttons to finish.

If an error occurs, the page will not be reloaded.

### Laravel Events

By default, clicking the button will trigger an event via AJAX.

Default event: `Dnwjn\NovaButton\Events\ButtonClick`.

The event will receive the key it was triggered from and, if available, the resource model:

* `$event->key` = `'notify'`
* `$event->resource` = `\Illuminate\Database\Eloquent\Model|null`

You can override the key:

```php
Button::make('Notify', 'notify-some-user')
```

And also the event:

```php
Button::make('Notify')->event(App\Events\NotifyRequested::class)
```

You can listen to the event by creating a listener and registering it in your `EventServiceProvider`.

### JavaScript Events

By default, clicking the button will cause an event to be dispatched via `Nova.$emit`.

Default event: `Dnwjn\NovaButton\Events\ButtonClick`.

The event can then be picked up via `Nova.$on`, and will receive the triggering key and, any optional arguments.

You can specify the key and optional arguments:

```php
Button::make('Notify', 'notify-some-user')
    ->emit('notification', ['article_id' => $article_id, 'which' => 'tags'])
```

You can listen to the event by creating a listener in your vue component or JavaScript:

```js
onMounted(function () {
    Nova.$on('notification', (e) => {
        if (e.article_id) {
            this.getOurStory(e.article_id, e.which === 'tags', e.which === 'story');
        }
    })
    // ...
}
```

### Texts

#### Title

You can set the title attribute for the button:

```php
Button::make('Notify')->title('Button title')
```

#### Label

You can set the label for the button, which is shown on the detail, create and update views:

```php
Button::make('Notify')->label('Button label')
```

#### Index name

You can set the index name for the button, which is shown on the index view as the table header:

```php
Button::make('Notify')->indexName('Actions')
```

Default is set to the button name. You can also pass `null` to have no index name.

### State

#### Visibility

You can conditionally show the button:

```php
Button::make('Activate')->visible($this->is_active === false),
Button::make('Deactivate')->visible($this->is_active === true),
```

Or, if you only want specific users to see the button:

```php
Button::make('Notify')->visible($request->user()->can('notifyUser', $this))
```

Of course you can also use Nova's builtin methods, like for [authorization](https://nova.laravel.com/docs/3.0/resources/authorization.html#fields)
or to limit visibility to [specific views](https://nova.laravel.com/docs/3.0/resources/fields.html#showing-hiding-fields).

If you want to show a button on the create or update views you can simply use Nova's builtin methods:

```php
Button::make('Notify')->showOnCreating()->showOnUpdating()
```

#### Disabled

You can disable the button:

```php
Button::make('Notify')->disabled()
Button::make('Notify')->disabled($this->is_complete === false)
```

### Feedback

When using events, you might want to provide visual feedback to the end user. This is especially useful for long running listeners.

```php
Button::make('Notify')
    ->loadingText('Sending...')
    ->successText('Sent!')
    ->errorText('Something went wrong...')
```

There are 3 events and for each event you can provide the text and style:

| Event     | Text                                     | Style                            |
|-----------|------------------------------------------|----------------------------------|
| `loading` | `->loadingText('Sending...')`            | `->loadingStyle('gray-outline')` |
| `success` | `->successText('Done!')`                 | `->successStyle('success')`      |
| `error`   | `->errorText('Something went wrong...')` | `->errorStyle('danger')`         |

The defaults are defined in the [config file](https://github.com/dnwjn/nova-button/blob/main/config/nova-button.php).

### Nova routes

You can also choose to navigate to any Nova route:

```php
Button::make('Text')->route('vuejs-route-name', ['id' => 1])
Button::make('Text')->index(App\Nova\User::class)
Button::make('Text')->detail(App\Nova\User::class, $this->user_id)
Button::make('Text')->create(App\Nova\User::class)
Button::make('Text')->edit(App\Nova\User::class, $this->user_id)
Button::make('Text')->lens(App\Nova\User::class, 'users-without-confirmation')
```

You can also set query parameters:

```php
Button::make('Text')
    ->route('home')
    ->withParams(['referrer' => 'nova'])
```

It's also possible to use a resource's filters:

```php
Button::make('Text')
    ->index(App\Nova\Order::class)
    ->withFilters([
        App\Nova\Filters\UserOrders::class => $this->user_id,
        App\Nova\Filters\OrderStatus::class => 'active',
    ])
```

### Links

You can configure the button to open external links:

```php
Button::make('Text')->link('https://nova.laravel.com')
Button::make('Text')->link('https://nova.laravel.com', '_self')
```

### Classes

The button uses the following classes that you can style to your liking:

```css
.nova-button
.nova-button-{resource-name}
.nova-button-success
.nova-button-error
.nova-button-loading
```

You can also add more classes to a button:

```php
// One class
Button::make('Notify')->classes('some-class')

// Or multiple classes
Button::make('Notify')->classes('some-class', 'another-class')
```

### Styles

This package uses [tailwind-css](https://tailwindcss.com) classes. The default class used is the `link` class.

You can define the class the button should use:

```php
Button::make('Delete')->style('danger')
```

The default available classes are as follows:

| Fill    | Outline         | Link         |
|---------|-----------------|--------------|
| primary | primary-outline | primary-link |
| success | success-outline | success-link |
| warning | warning-outline | warning-link |
| danger  | danger-outline  | danger-link  |
| info    | info-outline    | info-link    |
| gray    | gray-outline    | gray-link    |

The passed key refers to one of the classes defined in the [config file](https://github.com/dnwjn/nova-button/blob/main/config/nova-button.php).
You are free to change these classes or add your own.

## Examples

### Lenses

You can use a button with [lenses](https://nova.laravel.com/docs/3.0/lenses/defining-lenses.html).

![lens-example](https://user-images.githubusercontent.com/57711725/152637243-ebd753c2-5eda-4749-b8ba-c98ceb162e5b.png)

First set up the lens:

```php
<?php

namespace App\Nova\Lenses;

class UsersWithoutConfirmation extends Lens
{
    public static function query(LensRequest $request, $query)
    {
        return $query
            ->select(['users.id', 'users.name'])
            ->whereNull('email_verified_at');
    }

    public function fields(Request $request)
    {
        return [
            ID::make('ID', 'id'),
            Text::make('Name', 'name'),
            Button::make('Mark As Confirmed'),
        ];
    }
}
```

Next, register a listener for the `Dnwjn\NovaButton\Events\ButtonClick` event in your [EventServiceProvider](https://laravel.com/docs/7.x/events):

```php
<?php

namespace App\Listeners;

use Dnwjn\NovaButton\Events\ButtonClick;

class ConfirmUser
{
    public function handle(ButtonClick $event)
    {
        if ($event->key == 'mark-as-confirmed') {
            $event->resource->email_verified_at = now();
            $event->resource->save();
        }
    }
}
```

To confirm the event and event data used in above functionality, see the Telescope inspection below:

![telescope](https://user-images.githubusercontent.com/57711725/152637248-4bf65fa8-a270-48b9-aff3-08e6193eab6c.png)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [dnwjn](https://github.com/dnwjn)

Author of original package: [dillingham](https://github.com/dillingham)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
