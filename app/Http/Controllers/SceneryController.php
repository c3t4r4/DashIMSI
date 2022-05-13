<?php

namespace App\Http\Controllers;

use App\Models\Located;
use App\Models\Scenery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

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
        $scenery = Scenery::find($id);

        if($scenery->id > 0){
            $locateds = Located::where('created_at', '>=', convertDateTimeToDate($scenery->start))

            ->when($scenery->finish, function ($query, $finish){
                $query->where('created_at', '<=', convertDateTimeToDate($finish));
            })

            ->when($request->search, function ($query, $search){
                $query->where('imsi', 'like', "%${search}%")
                ->orWhere('timsi', 'like', "%${search}%")
                ->orWhere('created_at', 'like', "%${search}%");
            })
            ->orderBy("created_at", "desc");

            return Inertia::render('Scenery/show', [
                "locateds" => $locateds->get(),
                "scenery" => $scenery,
                "filters" => $request->only(['search'])
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
        //
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

        $scenery->update($request->all());

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
