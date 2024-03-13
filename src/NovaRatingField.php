<?php

namespace Classward\NovaRatingField;

use Laravel\Nova\Fields\Field;

class NovaRatingField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-rating-field';

    public function outOf(int $outOf = 5)
    {
        return $this->withMeta(['outOf' => $outOf]);
    }

    public function clearable(bool $clearable = true)
    {
        return $this->withMeta(['clearable' => $clearable]);
    }

}
