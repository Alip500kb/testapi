<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Models\game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

        $uploader = $request->user(); //ingat ini untuk mendefinisikan pengguna layaknya Auth user()
        // $request->bearerTOken() untuk mendapat personal acces token
        game::create([
            'id' => $id,
            'title' => $request['title'],
            'slug' => Str::slug($request['title'] . " LKS " . $id, "_"),
            'description' => $request['description'],
            'created_by' => $uploader['id']
        ]);

        $succes = [ //Str::slug untuk membuat slug
            'status' => 'Berhasil',
            'slug' => Str::slug($request['title'] . " LKS " . strval($id), "_")
        ];
        return response($succes,201);
    }
}
