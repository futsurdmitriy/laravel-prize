<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrizeController extends Controller
{
    /**
     * Gets random number defines random prize and assigns it to user.
     *
     * @return void
     * @throws Exception
     */
    public function __invoke()
    {
        $random_number = random_int(1,3);
        switch ($random_number) {
            case 1:
                // return random amount of money
            case 2:
                // return random amount of points
            case 3:
                // return random prize item
            default:
                // return try later
        }
//        return view('prize.result', ['prize' => User::findOrFail($id)]);
    }
}
