<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laptop;
use Barryvdh\DomPDF\Facade\Pdf;

class LaptopController extends Controller
{
    // =========================
    // TAMPILKAN DATA LAPTOP
    // =========================
   public function index(Request $request)
{
    $keyword = $request->keyword;
    $kondisi = $request->kondisi;

    $query = Laptop::query();

    // Pencarian
    if (!empty($keyword)) {

        $query->where(function ($q) use ($keyword) {

            $q->where(
                'nama_laptop',
                'like',
                "%$keyword%"
            )
            ->orWhere(
                'merk',
                'like',
                "%$keyword%"
            );

        });

    }

    // Filter kondisi
    if (!empty($kondisi)) {

        $query->where(
            'kondisi',
            $kondisi
        );

    }

    $laptops = $query
        ->paginate(5)
        ->withQueryString();

    return view(
        'laptops.index',
        compact(
            'laptops',
            'keyword',
            'kondisi'
        )
    );
}

    // =========================
    // FORM TAMBAH DATA
    // =========================
    public function create()
    {
        return view('laptops.create');
    }

    // =========================
    // SIMPAN DATA BARU
    // =========================
    public function store(Request $request)
    {
        $request->validate(

            [
                'nama_laptop' => [
                    'required',
                    'regex:/^[A-Z].*$/'

                ],

                'merk' => [
                    'required',
                    'regex:/^[A-Z][a-zA-Z0-9]*$/'
                ],

                'processor' => [
                    'required',
                    'regex:/^[A-Z][a-zA-Z0-9\s\-]*$/'
                ],

                'ram' => [
                    'required',
                    'regex:/^[0-9]+\sGB$/'
                ],

                'stok' => [
                    'required',
                    'integer',
                    'min:0'
                ]
            ],

            [
                'nama_laptop.required' =>
                    'Mohon maaf, kolom Nama Laptop masih kosong. Silakan isi terlebih dahulu.',

                'nama_laptop.regex' =>
                    'Nama laptop harus diawali huruf kapital pada setiap kata. Contoh: Asus Vivobook 14',

                'merk.required' =>
                    'Mohon maaf, kolom Merk masih kosong. Silakan isi terlebih dahulu.',

                'merk.regex' =>
                    'Merk harus diawali huruf kapital. Contoh: Asus',

                'processor.required' =>
                    'Mohon maaf, kolom Processor masih kosong. Silakan lengkapi terlebih dahulu.',

                'processor.regex' =>
                    'Nama processor harus diawali huruf kapital. Contoh: Intel Core i5-1135G7',

                'ram.required' =>
                    'Mohon maaf, kolom RAM masih kosong. Contoh penulisan: 8 GB atau 16 GB.',

                'ram.regex' =>
                    'Format RAM harus seperti: 4 GB, 8 GB, 16 GB',

                'stok.required' =>
                    'Mohon maaf, kolom Stok masih kosong. Silakan masukkan jumlah stok.',

                'stok.min' =>
                    'Stok tidak boleh kurang dari 0'
            ]
        );

        Laptop::create([
            'nama_laptop' => $request->nama_laptop,
            'merk' => $request->merk,
            'processor' => $request->processor,
            'ram' => $request->ram,
            'stok' => $request->stok,
            'kondisi' => $request->kondisi
        ]);

        return redirect('/laptops');
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit($id)
    {
        $laptop = Laptop::findOrFail($id);

        return view('laptops.edit', compact('laptop'));
    }

    // =========================
    // UPDATE DATA
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate(

            [
                'nama_laptop' => [
                    'required',
                    'regex:/^[A-Z].*$/'
                ],

                'merk' => [
                    'required',
                    'regex:/^[A-Z][a-zA-Z0-9]*$/'
                ],

                'processor' => [
                    'required',
                    'regex:/^[A-Z][a-zA-Z0-9\s\-]*$/'
                ],

                'ram' => [
                    'required',
                    'regex:/^[0-9]+\sGB$/'
                ],

                'stok' => [
                    'required',
                    'integer',
                    'min:0'
                ]
            ],

            [
                'nama_laptop.required' =>
                    'Mohon maaf, kolom Nama Laptop masih kosong. Silakan isi terlebih dahulu.',

                'nama_laptop.regex' =>
                    'Nama laptop harus diawali huruf kapital pada setiap kata. Contoh: Asus Vivobook 14',

                'merk.required' =>
                    'Mohon maaf, kolom Merk masih kosong. Silakan isi terlebih dahulu.',

                'merk.regex' =>
                    'Merk harus diawali huruf kapital. Contoh: Asus',

                'processor.required' =>
                    'Mohon maaf, kolom Processor masih kosong. Silakan lengkapi terlebih dahulu.',

                'processor.regex' =>
                    'Nama processor harus diawali huruf kapital. Contoh: Intel Core i5-1135G7',

                'ram.required' =>
                    'Mohon maaf, kolom RAM masih kosong. Contoh penulisan: 8 GB atau 16 GB.',

                'ram.regex' =>
                    'Format RAM harus seperti: 4 GB, 8 GB, 16 GB',

                'stok.required' =>
                    'Mohon maaf, kolom Stok masih kosong. Silakan masukkan jumlah stok.',

                'stok.min' =>
                    'Stok tidak boleh kurang dari 0'
            ]
        );

        $laptop = Laptop::findOrFail($id);

        $laptop->update([
            'nama_laptop' => $request->nama_laptop,
            'merk' => $request->merk,
            'processor' => $request->processor,
            'ram' => $request->ram,
            'stok' => $request->stok,
            'kondisi' => $request->kondisi
        ]);

        return redirect('/laptops');
    }

    // =========================
    // HAPUS DATA
    // =========================
    public function destroy($id)
    {
        $laptop = Laptop::findOrFail($id);

        $laptop->delete();

        return redirect('/laptops');
    }

    // =========================
    // DASHBOARD
    // =========================
   public function dashboard()
{
    $kondisiBaik = Laptop::where('kondisi', 'Baik')->count();

    $rusakRingan = Laptop::where(
        'kondisi',
        'Rusak Ringan'
    )->count();

    $rusakBerat = Laptop::where(
        'kondisi',
        'Rusak Berat'
    )->count();

    $totalLaptop =
        $kondisiBaik +
        $rusakRingan +
        $rusakBerat;

    return view('dashboard', compact(
        'totalLaptop',
        'kondisiBaik',
        'rusakRingan',
        'rusakBerat'
    ));
}
public function exportPdf()
{
    $laptops = Laptop::all();

    $pdf = Pdf::loadView(
        'laptops.pdf',
        compact('laptops')
    );

    return $pdf->download(
        'Laporan_Inventaris_Laptop.pdf'
    );
}
}