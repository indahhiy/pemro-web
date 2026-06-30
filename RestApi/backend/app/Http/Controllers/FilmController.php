<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $limit = $request->limit ?? 10;
        $page = $request->page ?? 1;

        $query = Film::query();

        if ($search) {
            $query->where('judul', 'like', "%$search%");
        }

        $films = $query->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diambil',
            'data' => $films->items(),
            'pagination' => [
                'page' => $films->currentPage(),
                'limit' => $films->perPage(),
                'total' => $films->total(),
                'total_pages' => $films->lastPage()
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode_film' => 'required|unique:films',
                'judul' => 'required',
                'genre' => 'required',
                'sutradara' => 'required',
                'tahun_rilis' => 'required|integer',
                'rating' => 'required|numeric'
            ]);

            $film = Film::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $film
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function show($id)
    {
        $film = Film::find($id);

        if (!$film) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diambil',
            'data' => $film
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $film = Film::find($id);

        if (!$film) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 404);
        }

        try {
            $validated = $request->validate([
                'kode_film' => 'required|unique:films,kode_film,' . $id,
                'judul' => 'required',
                'genre' => 'required',
                'sutradara' => 'required',
                'tahun_rilis' => 'required|integer',
                'rating' => 'required|numeric'
            ]);

            $film->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diubah',
                'data' => $film
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy($id)
    {
        $film = Film::find($id);

        if (!$film) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 404);
        }

        $film->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
            'data' => null
        ], 200);
    }
}