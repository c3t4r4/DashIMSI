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

        $unique = (!empty($request->unique) && $request->unique == "true" ? true : false);
        $search = (!empty($request->search) ? $request->search : "");

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
            ->orderBy("created_at", "desc");

            if(!empty($request->unique) && $request->unique == "true"){
                $locateds->groupBy('imsi_id');
            }
        return Inertia::render('IMSI/index', [
            "locateds" => $locateds->get(),
            "unique" => $unique,
            "search" => $search
        ]);
    }
}
