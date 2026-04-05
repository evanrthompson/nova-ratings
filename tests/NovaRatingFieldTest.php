<?php

use Evanrthompson\NovaRatingField\NovaRatingField;

it('has default meta values', function () {
    $field = NovaRatingField::make('Rating');
    $data = $field->jsonSerialize();

    expect($data['outOf'])->toBe(5)
        ->and($data['clearable'])->toBe(false)
        ->and($data['allowHalf'])->toBe(false)
        ->and($data['color'])->toBeNull()
        ->and($data['svg'])->toBeNull()
        ->and($data['emoji'])->toBeNull();
});

it('sets outOf via method', function () {
    $field = NovaRatingField::make('Rating')->outOf(10);
    $data = $field->jsonSerialize();

    expect($data['outOf'])->toBe(10);
});

it('sets clearable via method', function () {
    $field = NovaRatingField::make('Rating')->clearable();
    $data = $field->jsonSerialize();

    expect($data['clearable'])->toBe(true);
});

it('sets clearable to false explicitly', function () {
    $field = NovaRatingField::make('Rating')->clearable(false);
    $data = $field->jsonSerialize();

    expect($data['clearable'])->toBe(false);
});

it('sets allowHalf via method', function () {
    $field = NovaRatingField::make('Rating')->allowHalf();
    $data = $field->jsonSerialize();

    expect($data['allowHalf'])->toBe(true);
});

it('sets color via method', function () {
    $field = NovaRatingField::make('Rating')->color('#f59e0b');
    $data = $field->jsonSerialize();

    expect($data['color'])->toBe('#f59e0b');
});

it('sets emoji via method', function () {
    $field = NovaRatingField::make('Rating')->emoji('🔥');
    $data = $field->jsonSerialize();

    expect($data['emoji'])->toBe('🔥');
});

it('reads svg file and sets meta', function () {
    $path = tempnam(sys_get_temp_dir(), 'svg');
    file_put_contents($path, '<svg viewBox="0 0 24 24"><path d="M12 0"/></svg>');

    $field = NovaRatingField::make('Rating')->svg($path);
    $data = $field->jsonSerialize();

    expect($data['svg'])->toBe('<svg viewBox="0 0 24 24"><path d="M12 0"/></svg>');

    unlink($path);
});

it('throws exception for non-existent svg file', function () {
    NovaRatingField::make('Rating')->svg('/nonexistent/path.svg');
})->throws(InvalidArgumentException::class);

it('last icon method wins between svg and emoji', function () {
    $path = tempnam(sys_get_temp_dir(), 'svg');
    file_put_contents($path, '<svg><path d="M0 0"/></svg>');

    // emoji called last — emoji wins
    $field = NovaRatingField::make('Rating')->svg($path)->emoji('🔥');
    $data = $field->jsonSerialize();
    expect($data['emoji'])->toBe('🔥')
        ->and($data['svg'])->toBeNull();

    // svg called last — svg wins
    $field = NovaRatingField::make('Rating')->emoji('🔥')->svg($path);
    $data = $field->jsonSerialize();
    expect($data['svg'])->toBe('<svg><path d="M0 0"/></svg>')
        ->and($data['emoji'])->toBeNull();

    unlink($path);
});

it('supports method chaining', function () {
    $field = NovaRatingField::make('Rating')
        ->outOf(10)
        ->clearable()
        ->allowHalf()
        ->color('#ff0000')
        ->emoji('❤️');

    $data = $field->jsonSerialize();

    expect($data['outOf'])->toBe(10)
        ->and($data['clearable'])->toBe(true)
        ->and($data['allowHalf'])->toBe(true)
        ->and($data['color'])->toBe('#ff0000')
        ->and($data['emoji'])->toBe('❤️');
});

it('sets outOf to default 5 when called with no arguments', function () {
    $field = NovaRatingField::make('Rating')->outOf(10)->outOf();
    $data = $field->jsonSerialize();

    expect($data['outOf'])->toBe(5);
});

it('sets allowHalf to false explicitly', function () {
    $field = NovaRatingField::make('Rating')->allowHalf()->allowHalf(false);
    $data = $field->jsonSerialize();

    expect($data['allowHalf'])->toBe(false);
});

it('does not clear svg or emoji when setting color', function () {
    $field = NovaRatingField::make('Rating')->emoji('🔥')->color('#ff0000');
    $data = $field->jsonSerialize();

    expect($data['color'])->toBe('#ff0000')
        ->and($data['emoji'])->toBe('🔥');

    $path = tempnam(sys_get_temp_dir(), 'svg');
    file_put_contents($path, '<svg><circle r="10"/></svg>');

    $field = NovaRatingField::make('Rating')->svg($path)->color('#00ff00');
    $data = $field->jsonSerialize();

    expect($data['color'])->toBe('#00ff00')
        ->and($data['svg'])->toBe('<svg><circle r="10"/></svg>');

    unlink($path);
});

it('reads multiline svg content correctly', function () {
    $svgContent = <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
  <path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8Z"/>
  <circle cx="12" cy="12" r="3"/>
</svg>
SVG;

    $path = tempnam(sys_get_temp_dir(), 'svg');
    file_put_contents($path, $svgContent);

    $field = NovaRatingField::make('Rating')->svg($path);
    $data = $field->jsonSerialize();

    expect($data['svg'])->toBe($svgContent);

    unlink($path);
});

it('has the correct component name', function () {
    $field = NovaRatingField::make('Rating');

    expect($field->component)->toBe('nova-rating-field');
});

it('resolves value from model attribute', function () {
    $model = new stdClass;
    $model->rating = 0.7;

    $field = NovaRatingField::make('Rating');
    $field->resolve($model);
    $data = $field->jsonSerialize();

    expect($data['value'])->toBe(0.7);
});

it('uses correct attribute when explicitly provided', function () {
    $field = NovaRatingField::make('Spice Level', 'spice_level');

    expect($field->attribute)->toBe('spice_level');

    $model = new stdClass;
    $model->spice_level = 3;

    $field->resolve($model);
    $data = $field->jsonSerialize();

    expect($data['value'])->toBe(3);
});

it('merges custom withMeta alongside rating meta', function () {
    $field = NovaRatingField::make('Rating')
        ->outOf(5)
        ->allowHalf()
        ->withMeta(['customKey' => 'customValue']);

    $data = $field->jsonSerialize();

    expect($data['outOf'])->toBe(5)
        ->and($data['allowHalf'])->toBe(true)
        ->and($data['customKey'])->toBe('customValue');
});
