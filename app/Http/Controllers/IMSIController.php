<?php

namespace App\Http\Controllers;

use App\Models\Imsi;
use App\Models\Located;
use App\Models\Timsi;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
            ->when($unique, function ($query){
                $query->groupBy('imsi_id','id');
            });

            if($unique){
                $locateds = Located::whereIn('id',$locateds->get('id')->toArray())
                ->with('imsi')
                ->with('timsi');
            }else{
                $locateds->orderBy("created_at", "desc");
            }
            
            $locateds->orderBy("created_at", "desc");

            // if(!empty($request->unique) && $request->unique == "true"){
            //     $oldlocatedes = $locateds->get('id')->toArray('id');
            //     dd($oldlocatedes);
            //     //$locateds = DBgroupBy('imsi_id');
            // }
        return Inertia::render('IMSI/index', [
            "locateds" => $locateds->get(),
            "unique" => $request->unique,
            "search" => $search
        ]);
    }
}
