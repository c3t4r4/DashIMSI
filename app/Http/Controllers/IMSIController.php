<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class IMSIController extends Controller
{
    public function index(Request $request){
        $locateds = DB::connection('sqliteIMSI')
        ->table("LOCATED")
        ->join("IMSI", function ($join) {
            $join->on("LOCATED.IMSI_ID", "=", "IMSI.ID");
        })
        ->join("TIMSI", function ($join) {
            $join->on("LOCATED.TIMSI_ID", "=", "TIMSI.ID");
        })
        ->orderBy("CREATED_AT", "desc")
        ->get();
        
        return Inertia::render('IMSI/index', [
            "locateds" => $locateds
        ]);
    }
}
