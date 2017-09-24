<?php

namespace App;

use App\Conversion;
use League\Fractal\TransformerAbstract;

class ConversionTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Conversion $conversion)
    {
        return [
            'id' => (int) $conversion->id,
            'integer' => (int) $conversion->integer,
            'numeral' => $conversion->numeral,
            'created' => $conversion->created_at->toDateTimeString()
        ];
    }
}
