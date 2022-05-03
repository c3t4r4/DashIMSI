<?php

namespace App\Http\Controllers;

use App\Models\Located;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class IMSIController extends Controller
{
    public function index(Request $request){
        $locateds = Located::allItens()->get();

        dd($locateds);
        
        return Inertia::render('IMSI/index', [
            "locateds" => $locateds
        ]);
    }
}
