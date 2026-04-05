# Nova Ratings

A star rating field for Laravel Nova 5 with half-star ratings, custom icons, and color customization.

## Requirements

- PHP 8.3+
- Laravel Nova 5.0+

## Installation

```bash
composer require evanrthompson/nova-ratings
```

## Usage

Add the field to your Nova resource:

```php
use Evanrthompson\NovaRatings\NovaRatings;

public function fields(NovaRequest $request): array
{
    return [
        NovaRatings::make('Rating'),
    ];
}
```

## Options

### `outOf(int $outOf)`

Set the maximum rating scale. Default: `5`.

```php
NovaRatings::make('Rating')->outOf(10)
```

### `clearable()`

Show a clear button that resets the rating to 0.

```php
NovaRatings::make('Rating')->clearable()
```

### `allowHalf()`

Enable half-star increments. Clicking the left half of an icon sets a `.5` value, the right half sets a whole value.

```php
NovaRatings::make('Rating')->allowHalf()
```

### `color(string $color)`

Set the filled icon color using any CSS color value.

```php
NovaRatings::make('Rating')->color('#f59e0b')
```

### `svg(string $path)`

Use a custom SVG file instead of the default star. The SVG file is read at render time and should use `currentColor` for its fill to work with `color()`.

```php
NovaRatings::make('Rating')->svg(public_path('icons/heart.svg'))
```

### `emoji(string $emoji)`

Use an emoji character instead of stars.

```php
NovaRatings::make('Rating')->emoji('🔥')
```

> **Note:** `svg()` and `emoji()` are mutually exclusive. If both are called, the last one wins.

## Database

Ratings are always stored as a **decimal between 0 and 1** (percentage of the maximum scale). Use a decimal column:

```php
$table->decimal('rating', 3, 2)->default(0);
```

The field automatically converts between the stored percentage and the visual scale. For example, a rating of 3.5 out of 5 is stored as `0.70`.

## Configuration Example

A real-world resource using multiple rating fields with different configurations:

```php
use Evanrthompson\NovaRatings\NovaRatings;

public function fields(NovaRequest $request): array
{
    return [
        NovaRatings::make('Rating')
            ->outOf(5)
            ->clearable()
            ->allowHalf()
            ->sortable()
            ->help('Overall recipe rating'),

        NovaRatings::make('Flavor')
            ->outOf(5)
            ->allowHalf()
            ->svg(public_path('icons/heart.svg'))
            ->color('#ef4444'),

        NovaRatings::make('Spice Level', 'spice_level')
            ->outOf(5)
            ->allowHalf()
            ->emoji('🌶️'),

        NovaRatings::make('Difficulty')
            ->outOf(3)
            ->emoji('🔪'),
    ];
}
```

## Nova Compatibility

The field works with Nova's built-in `readonly()`, `help()`, `sortable()`, and `rules()` methods.

## License

MIT
