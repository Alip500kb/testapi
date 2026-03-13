<?php

namespace App\Http\Controllers;

use App\Http\Resources\pemainResource;
use App\Models\pemain;
use Illuminate\Http\Request;

class pemainController extends Controller
{
    public function index() {
        $pengguna = pemain::all()->map(fn($pengguna) => [
            'nama_pengguna' => $pengguna->username,
            'last_login_at' => $pengguna->last_login_at,
            'created_at' => $pengguna->created_at,
            'updated_at' => $pengguna->updated_at
        ]);

        return new pemainResource($pengguna);
    }

}
