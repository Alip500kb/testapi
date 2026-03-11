<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Models\game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function index()
    {
        $gamelist = game::all()->map(fn($gamelist) => [
            'slug' => $gamelist->slug,
            'title' => $gamelist->title,
            'description' => $gamelist->description,
            'created_by' => $gamelist->created_by,
            'uploaded_at' => $gamelist->created_at
        ] ); //plis ingat ini astaga

        return new GameResource(200, 'Game Lists', $gamelist); //return ke game resource menggunakan construct
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'title' => 'required|unique:games,title',
            'description' => 'required'
        ]);

        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }

        do {
            $id = rand(1,5555);
        } while (game::where('id',$id)->exists());

        game::create([
            'id' => $id,
            'title' => $request['title'],
            'slug' => $request['title'] . "LKS" . strval($id),
            'description' => $request['description'],
            'created_by' => $request['created_by']
        ]);

        $succes = [
            'status' => 'Berhasil',
            'slug' => $request['title'] . "LKS" . strval($id)
        ];
        return response($succes,201);
    }
}
