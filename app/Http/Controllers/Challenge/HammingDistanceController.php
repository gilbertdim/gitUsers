<?php

namespace App\Http\Controllers\Challenge;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

class HammingDistanceController extends Controller
{
    public function index()
    {
        return view('challenges.hammingdistance');
    }

    public function calculate(Request $request)
    {
        $a = $request->input('firstInt');
        $b = $request->input('secondInt');

        if($a < 0) return response()->json([
            'error' => 'X should be greater than or equal to 0'
        ]);

        if($b >= 2147483648) return response()->json([
            'error' => 'Y should be less than 2<sup>31</sup>'
        ]);

        $a_bin = decbin($a);
        $b_bin = decbin($b);

        $a_bin = Str::padLeft($a_bin, Str::length($b_bin) + 2, 0);
        $b_bin = Str::padLeft($b_bin, Str::length($b_bin) + 2, 0);

        if(Str::length($a_bin) > Str::length($b_bin))
        {
            $a_bin = Str::padLeft($a_bin, Str::length($a_bin) + 2, 0);
            $b_bin = Str::padLeft($b_bin, Str::length($a_bin) + 2, 0);
        }

        $a_arr = str_split($a_bin);
        $b_arr = str_split($b_bin);
        $diff_arr = array();

        for($i = 0; $i < count($a_arr); $i++)
            if($a_arr[$i] != $b_arr[$i])
                array_push($diff_arr, $i);

        return response()->json(array(
            'x' => array(
                'integer' => $a,
                'binary' => $a_bin,
            ),
            'y' => array(
                'integer' => $b,
                'binary' => $b_bin,
            ),
            'distance' => array(
                'value' => count($diff_arr),
                'coordinates' => $diff_arr,
            ),
        ));
    }
}
