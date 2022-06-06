<?php

namespace App\Http\Controllers;

use App\Models\Located;
use App\Models\Scenery;
use App\Models\Imsi;
use App\Models\Timsi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\Object_;
use stdClass;

class SceneryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sceneries = Scenery::query()
        ->when($request->search, function ($query, $search){
            $query->where('description', 'like', "%${search}%")
            ->orWhere('lat', 'like', "%${search}%")
            ->orWhere('lng', 'like', "%${search}%")
            ->orWhere('start', 'like', "%${search}%")
            ->orWhere('finish', 'like', "%${search}%");
        })
        ->orderBy("created_at", "desc");

        return Inertia::render('Scenery/index', [
            "sceneries" => $sceneries->get(),
            "filters" => $request->only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Scenery/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->route('scenery.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $scenery = new Scenery();
        $scenery->fill($request->all());
        $scenery->lc_start = $scenery->start;
        $scenery->lc_finish = $scenery->finish;

        if (!$scenery->save()) {
            return redirect()
                        ->route('scenery.create')
                        ->withInput();
        }

        return redirect()->route('scenery.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if(!is_numeric($id)){
            return redirect()->route('scenery.index');
        }

        $scenery = Scenery::find($id);

        if($scenery->id > 0){

            $unique = (!empty($request->unique) && $request->unique == "true" ? true : false);

            $locateds = Located::with('imsi')
            ->with('timsi')
            ->where('created_at', '>=', convertStringToDateTime($scenery->lc_start))

            ->when($scenery->lc_finish, function ($query, $finish){
                $query->where('created_at', '<=', convertStringToDateTime($finish));
            })

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
                $query->distinct('imsi_id');
            });

            return Inertia::render('Scenery/show', [
                "locateds" => $locateds->get(),
                "scenery" => $scenery,
                "search" => $request->search,
                "unique" => $request->unique
            ]);

        }

        return redirect()->route('scenery.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $scenery = Scenery::find($id);

        if($scenery->id > 0){
            $object = new stdClass;
            $object->id = $scenery->id;
            //$object->start = convertStringToDateTimeVue($scenery->start);
            $object->lc_start = convertStringToDateTimeVue($scenery->lc_start);
            //$object->finish = (!empty($scenery->finish) ? convertStringToDateTimeVue($scenery->finish) : "");
            $object->lc_finish = (!empty($scenery->finish) ? convertStringToDateTimeVue($scenery->lc_finish) : "");
            $object->lat = $scenery->lat;
            $object->lng = $scenery->lng;
            $object->description = $scenery->description;

            return Inertia::render('Scenery/edit', [
                "scenery" => $object
            ]);
        }

        return redirect()->route('scenery.index');

    }

    public function finishScenery($id)
    {
        $scenery = Scenery::find($id);

        if($scenery->id > 0){
            $scenery->finish = now();
            $scenery->save();
        }

        return redirect()->route('scenery.index');
    }


    public function renewScenery($id)
    {
        $scenery = Scenery::find($id);

        if($scenery->id > 0){
            $scenery->finish = null;
            $scenery->save();
        }

        return redirect()->route('scenery.index');
    }

    public function compareScenery(Request $request)
    {
        $ids = $request->scenaries ?? $request->all();
        $initIDS = NULL;

        $scenariesTitle = [];

        foreach($ids as $id){

            if(!is_numeric($id)){
                return redirect()->route('scenery.index');
            }

            $scenary = Scenery::find($id);

            $scenariesTitle[] = $scenary;

            $LocatedIDS = Located::where("created_at", ">=", $scenary->start);

            if(!empty($scenary->finish)){
                $LocatedIDS->where("created_at", "<=", $scenary->finish);
            }

            if(!$initIDS){
                $initIDS = $LocatedIDS->pluck('id')->toArray();
            }else{
                $initIDS = array_intersect($initIDS, $LocatedIDS->pluck('id')->toArray());
            }
        }

        $unique = (!empty($request->unique) && $request->unique == "true" ? true : false);

        $locateds = Located::with('imsi')
        ->with('timsi')
        ->whereIn("id", $initIDS)
        ->when($unique, function ($query){
            $query->distinct('imsi_id');
        });

        return Inertia::render('Scenery/compare', [
            "scenaries" => $ids,
            "scenariesTitle" => $scenariesTitle,
            "locateds" => $locateds->get(),
            "search" => $request->search,
            "unique" => $request->unique
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $scenery = Scenery::find($id);

        $validator = Validator::make($request->all(), [
            'start' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->route('scenery.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $scenery->start = $request->start;
        $scenery->lc_start = $request->start;
        $scenery->finish = $request->finish;
        $scenery->lc_finish = $request->finish;
        $scenery->description = $request->description;
        $scenery->lat = $request->lat;
        $scenery->lng = $request->lng;

        

        if (!$scenery->save()) {
            return redirect()
                        ->route('scenery.edit')
                        ->withInput();
        }



        return redirect()->route('scenery.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $scenery = Scenery::find($id);

        if($scenery->id > 0){
            $scenery->delete();
        }

        return redirect()->route('scenery.index');
    }
}
