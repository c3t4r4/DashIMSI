<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Imsi;
use App\Models\Timsi;
use App\Models\Located;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'type' => 'required',
        //     'datetimsi' => 'required',
        //     'timsi' => 'required',
        //     'imsi' => 'required|min:15',
        //     'dateimsi' => 'required',
        // ]);



        if(!$request->type || !$request->datetimsi || !$request->timsi || !$request->imsi || !$request->dateimsi){
            return response()->json("Erro Falta Dados!!!", 406);
        }

        $imsi = Imsi::firstOrCreate([
            'imsi' => $request->imsi,
        ]);

        if($imsi->id > 0){
            $timsi = Timsi::firstOrCreate([
                'imsi_id' => $imsi->id,
                'timsi' => $request->timsi,
            ]);
        }

        if($imsi->id > 0 && $timsi->id){
            $located = Located::firstOrCreate([
                'imsi_id' => $imsi->id,
                'timsi_id' => $timsi->id,
                'created_at' => $request->datetimsi
            ]);
        }

        return response()->json('{ "msg": "Criado com Sucesso!!!", "Located": "'.$located->id.'" }', 201);
    }
}
