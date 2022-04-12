<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CheckingController extends Controller
{
    public function checkLtoAnnexs(Request $request, $appid)
    {

        $annexa = DB::table('hfsrbannexa')->where('appid', $appid)->first();
        $annexb = DB::table('hfsrbannexb')->where('appid', $appid)->first();

        $initialmsg = "succ";

        if(is_null($annexa) || is_null($annexb)){
            $initialmsg = "Please provide the following: ";

            if(is_null($annexa)){
                $initialmsg .= "Personnel (Annex A),";
            }

            if(is_null($annexb)){
                $initialmsg .= "Equipment/Instrument (Annex B),";
            }
        }

       


        return response()->json(
            [
                'filled' => $initialmsg,
                'id' => $appid,

            ],
            200
        );
    }

    // CheckingController
}
