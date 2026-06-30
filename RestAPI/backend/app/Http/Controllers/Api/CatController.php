<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatController extends Controller
{
    // ================= GET ALL + SEARCH + PAGINATION =================
    public function index(Request $request)
    {
        $search = $request->query('search');
        $limit = $request->query('limit', 10);

        $query = Cat::query();

        if ($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('ras', 'like', "%{$search}%")
                  ->orWhere('warna', 'like', "%{$search}%");
        }

        $cats = $query->paginate($limit);

        return response()->json([
            'success' => true,
            'message' => 'Data kucing berhasil diambil',
            'data' => $cats
        ], 200);
    }

    // ================= GET DETAIL =================
    public function show($id)
    {
        $cat = Cat::find($id);

        if (!$cat) {
            return response()->json([
                'success' => false,
                'message' => 'Data kucing tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data kucing',
            'data' => $cat
        ], 200);
    }

    // ================= POST =================
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'ras' => 'required|string|max:100',
            'warna' => 'required|string|max:50',
            'umur' => 'required|integer|min:0',
            'jenis_kelamin' => 'required|in:Jantan,Betina',
            'berat' => 'required|numeric|min:0',
            'status_vaksin' => 'required|in:Sudah,Belum'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek data duplikat
        $exists = Cat::where('nama', $request->nama)
            ->where('ras', $request->ras)
            ->where('warna', $request->warna)
            ->first();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Data kucing sudah ada'
            ], 409);
        }

        $cat = Cat::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data kucing berhasil ditambahkan',
            'data' => $cat
        ], 201);
    }

    // ================= PUT =================
    public function update(Request $request, $id)
    {
        $cat = Cat::find($id);

        if (!$cat) {
            return response()->json([
                'success' => false,
                'message' => 'Data kucing tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'ras' => 'required|string|max:100',
            'warna' => 'required|string|max:50',
            'umur' => 'required|integer|min:0',
            'jenis_kelamin' => 'required|in:Jantan,Betina',
            'berat' => 'required|numeric|min:0',
            'status_vaksin' => 'required|in:Sudah,Belum'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek data duplikat selain data yang sedang diedit
        $exists = Cat::where('nama', $request->nama)
            ->where('ras', $request->ras)
            ->where('warna', $request->warna)
            ->where('id', '!=', $id)
            ->first();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Data kucing sudah ada'
            ], 409);
        }

        $cat->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data kucing berhasil diupdate',
            'data' => $cat
        ], 200);
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $cat = Cat::find($id);

        if (!$cat) {
            return response()->json([
                'success' => false,
                'message' => 'Data kucing tidak ditemukan'
            ], 404);
        }

        $cat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data kucing berhasil dihapus'
        ], 200);
    }
}