<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laptop;

class LaptopApiController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;

    $query = Laptop::query();

    if (!empty($search)) {

        $query->where(function ($q) use ($search) {

            $q->where(
                'nama_laptop',
                'like',
                "%{$search}%"
            )

            ->orWhere(
                'merk',
                'like',
                "%{$search}%"
            );

        });
    }

    $laptops = $query->paginate(10);

    return response()->json([

        'status' => true,

        'message' => 'Data laptop berhasil diambil',

        'data' => $laptops->items(),

        'pagination' => [

            'page' => $laptops->currentPage(),

            'limit' => $laptops->perPage(),

            'total' => $laptops->total(),

            'total_pages' => $laptops->lastPage()

        ]

    ]);
}

    public function show($id)
    {
        $laptop = Laptop::find($id);

        if (!$laptop) {

            return response()->json([
                'status' => false,
                'message' => 'Data laptop tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail laptop berhasil diambil',
            'data' => $laptop
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_laptop' => 'required',
        'merk' => 'required',
        'processor' => 'required',
        'ram' => 'required',
        'stok' => 'required|integer',
        'kondisi' => 'required'
    ]);

    $laptop = Laptop::create([
        'nama_laptop' => $request->nama_laptop,
        'merk' => $request->merk,
        'processor' => $request->processor,
        'ram' => $request->ram,
        'stok' => $request->stok,
        'kondisi' => $request->kondisi
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Data laptop berhasil ditambahkan',
        'data' => $laptop
    ], 201);
}

public function update(Request $request, $id)
{
    $laptop = Laptop::find($id);

    if (!$laptop) {

        return response()->json([
            'status' => false,
            'message' => 'Data laptop tidak ditemukan'
        ], 404);
    }

    $request->validate([
        'nama_laptop' => 'required',
        'merk' => 'required',
        'processor' => 'required',
        'ram' => 'required',
        'stok' => 'required|integer',
        'kondisi' => 'required'
    ]);

    $laptop->update([
        'nama_laptop' => $request->nama_laptop,
        'merk' => $request->merk,
        'processor' => $request->processor,
        'ram' => $request->ram,
        'stok' => $request->stok,
        'kondisi' => $request->kondisi
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Data laptop berhasil diperbarui',
        'data' => $laptop
    ]);
}

public function destroy($id)
{
    $laptop = Laptop::find($id);

    if (!$laptop) {

        return response()->json([
            'status' => false,
            'message' => 'Data laptop tidak ditemukan'
        ], 404);
    }

    $laptop->delete();

    return response()->json([
        'status' => true,
        'message' => 'Data laptop berhasil dihapus'
    ]);
}
}