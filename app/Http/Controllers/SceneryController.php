<?php

namespace App\Http\Controllers;

use App\Models\Scenery;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
