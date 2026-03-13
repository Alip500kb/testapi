<?php

namespace App\Http\Controllers;

use App\Models\pemain;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class loginKing extends Controller
{
    public function index(Request $request) { //get
        $valid = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('pemains')->attempt($valid)) {
            $user = pemain::where('username', $valid['username'])->first(); //memuat data sesi login
            // $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'status' => 'berhasil',
                'token' => $user->createToken('user-login')->plainTextToken,
            ], 200);
        }
        return response()->json([
                'status' => 'gagal',
                'message' => 'Nama Pengguna atau sandi salah',
            ], 401);
    }


    public function login(Request $request)
    {
        $valid = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = pemain::where('username', $valid['username'])->first(); //memuat data sesi login

        if (Auth::guard('pemains')->attempt($valid)) {
            Auth::guard('pemains')->attempt($valid);
            $request->session()->regenerate();
            return $user->createToken('user login')->plainTextToken;
            // return $request->createToken($request->device_name)->plainTextToken;
        } //generate token nya nggak  bisa sialan
        return 'gagal';
    }


    public function store(Request $request) //POST
    {
        if ((pemain::where('username', $request['username'])->exists())) {
            return response()->json(['status' => 'tidak valid', 'message' => 'Nama Pengguna Sudah Ada'],400);
        }

        $valid = validator($request->all(), [
            'username' => 'required|string|min:4|unique:pemains,username',
            'password' => 'required|min:5'
        ]);

        if ($valid->fails()) {
            return response()->json($valid->errors(), 401);
        }
        do {
            $id  = rand(1,63636);
        } while (pemain::where('id', $id)->exists());

        pemain::create([
            'id' => $id,
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'last_login_at' => Carbon::now()
        ]);
        $pengguna = pemain::where('username', $request['username'])->first();
        $sukses = [
            'status' => 'berhasil',
            'token' => $pengguna->createToken('user-login')->plainTextToken //membuat token untuk login sanctum
            ];
        return response()->json($sukses, 201);
    }

    public function logout(Request $request) {
        // dd($request);
        if (!(pemain::where('id', $request->user())->exists())) {
            return response()->json(['status' => 'tidak ditemukan', 'message' => 'Pengguna Tidak Ditemukan'],403);
        }

        $request->user()->currentAccessToken()->delete();
        $berhasil = [
            'status' => 'berhasil'
        ];
        return response()->json($berhasil, 204);
    }
}
