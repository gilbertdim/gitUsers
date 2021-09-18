<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class APIController extends Controller
{
    public static function get($url, $header = [], $query = [])
    {
        return HTTP::withHeaders($header)->get($url, $query);
    }
}
