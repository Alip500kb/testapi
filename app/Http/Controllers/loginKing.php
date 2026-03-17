<?php

namespace App\Http\Controllers;

use App\Models\pemain;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Nette\Utils\Json;

class loginKing extends Controller
{
    public function index(Request $request) { //get
        $valid = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('pemains')->attempt($valid)) {
            $user = pemain::where('username', $valid['username'])->first(); //memuat data sesi login
            $user->tokens()->delete();
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
            'role_id' => '3', //jangan lupa ditambahkan pada fillable
            'last_login_at' => Carbon::now() //jangan lupa juga untuk cek di role kalau id nya sudah ada
        ]);
        $pengguna = pemain::where('username', $request['username'])->first();
        $sukses = [
            'status' => 'berhasil',
            'username' => $pengguna['username'] //membuat token untuk login sanctum
            ];
        return response()->json($sukses, 201);
    }

    public function logout(Request $request) {
        //$request->user() hanya dapat digunakan jika sudah menggunakan middleware sanctum
        $request->user()->currentAccessToken()->delete();
        $berhasil = [
            'status' => 'berhasil'
        ];
        return response()->json($berhasil, 204);
    }

    public function update(Request $request,$id) {

        if (!Gate::allows('administrator')) {
            return response()->json(['status' => 'dilarang', 'message' => 'Anda bukan administrator'], 403);
        }

        //perlu id karena PUT tidak dapat diakses tanpa /{id}
        $valid = Validator::make($request->all(),
        [
            'username' => 'required|min:4|max:60',
            'password' => 'required|min:5|max:10'
        ]);

        if ($valid->fails()) {
            return response()->json($valid->errors(),400);
        }

        $pemain = pemain::find($id);

        $pemain->update([
            'username' => $request['username'],
            'password' => Hash::make($request['password'])
        ]);

        return response()->json(['status' => 'berhasil', 'username' => $request['username']], 201);
    }

    public function destroy($id) {
        if (!pemain::where('id', $id)->exists()) {
            return response()->json(['status' => 'tidak ditemukan', 'message' => 'Pengguna tidak ditemukan'],  403);
        }

        $pemain = pemain::find($id);

        $pemain->delete();

        return response()->json(['null'], 204);
    }
}
