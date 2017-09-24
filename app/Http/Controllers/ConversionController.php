<?php

namespace App\Http\Controllers;

use App\Conversion;
use App\ConversionTransformer;
use App\IntegerConversion;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class ConversionController extends Controller
{
    /**
     * Convert an integer to a roman numeral and store in db.
     *
     * @param  IntegerConversion $converter A converter implementation
     * @param  int               $integer   The integer to convert
     *
     * @return string                       A JSON string containing the integer
     *                                      and its corresponding numeral
     */
    public function convert(IntegerConversion $converter, $integer)
    {
        if (!$numeral = $converter->toRomanNumerals($integer)) {
            $numeral = 'out of scope';
        }

        $conversion = new Conversion();
        $conversion->integer = $integer;
        $conversion->numeral = $numeral;

        $conversion->save();

        return response()->json([$integer => $numeral]);
    }

    /**
     * Lists all previous conversions.
     *
     * @return string   A JSON string containing all conversions
     */
    public function all()
    {
        $conversions = Conversion::all();

        $collection = new Collection($conversions, new ConversionTransformer());
        $fractal = new Manager();

        return $fractal->createData($collection)->toJson();
    }

    /**
     * Lists top ten previous conversions.
     *
     * @return string   A JSON string containing the top-ten conversions
     */
    public function topTen()
    {
        $conversions = Conversion::select(
                DB::raw('conversions.integer, conversions.numeral, count(conversions.integer) as count')
            )
            ->groupBy('conversions.integer')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        return response()->json($conversions);
    }
}
