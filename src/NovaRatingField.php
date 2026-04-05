<?php

namespace Evanrthompson\NovaRatingField;

use InvalidArgumentException;
use Laravel\Nova\Fields\Field;

class NovaRatingField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-rating-field';

    /**
     * @var array<string, mixed>
     */
    protected $ratingMeta = [
        'outOf' => 5,
        'clearable' => false,
        'allowHalf' => false,
        'color' => null,
        'svg' => null,
        'emoji' => null,
    ];

    public function outOf(int $outOf = 5): static
    {
        $this->ratingMeta['outOf'] = $outOf;

        return $this;
    }

    public function clearable(bool $clearable = true): static
    {
        $this->ratingMeta['clearable'] = $clearable;

        return $this;
    }

    public function allowHalf(bool $allowHalf = true): static
    {
        $this->ratingMeta['allowHalf'] = $allowHalf;

        return $this;
    }

    public function color(string $color): static
    {
        $this->ratingMeta['color'] = $color;

        return $this;
    }

    public function svg(string $path): static
    {
        if (! file_exists($path)) {
            throw new InvalidArgumentException("SVG file not found: {$path}");
        }

        $this->ratingMeta['svg'] = file_get_contents($path);
        $this->ratingMeta['emoji'] = null;

        return $this;
    }

    public function emoji(string $emoji): static
    {
        $this->ratingMeta['emoji'] = $emoji;
        $this->ratingMeta['svg'] = null;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $this->withMeta($this->ratingMeta);

        return parent::jsonSerialize();
    }
}
