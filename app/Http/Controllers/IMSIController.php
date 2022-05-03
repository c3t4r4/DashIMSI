<?php

namespace App\Http\Controllers;

use App\Models\Imsi;
use App\Models\Located;
use App\Models\Timsi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class IMSIController extends Controller
{
    public function index(Request $request){
        $locateds = Located::query()
            ->with('imsi')
            ->with('timsi')
            ->when($request->search, function ($query, $search){
                $imsiIDS = Imsi::where('imsi', 'like', "%${search}%")->get('id')->toArray();
                $timsiIDS = Timsi::where('timsi', 'like', "%${search}%")->get('id')->toArray();

                $query->where(function($query) use($imsiIDS) {
                    $query->whereIn('imsi_id', $imsiIDS);
                });
                $query->orWhere(function($query) use($timsiIDS) {
                    $query->whereIn('timsi_id', $timsiIDS);
                });
            })
            ->get();
        
        return Inertia::render('IMSI/index', [
            "locateds" => $locateds,
            "filters" => $request->only(['search']),
        ]);
    }
}
