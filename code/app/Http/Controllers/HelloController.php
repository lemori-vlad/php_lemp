<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    function supportedBranches(Request $request) {
        return json_encode([
            'ok' => true,
            'branches' => [1,4,7]
        ]);
    }
}
