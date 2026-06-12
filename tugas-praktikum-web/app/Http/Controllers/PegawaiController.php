<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class PegawaiController extends Controller
{
    /**
     * GET: Mengambil semua data dengan fitur Search & Pagination
     */
    public function index(Request $request)
    {
        try {
            $query = Pegawai::query();

            // Fitur Search via query params (?search=...)
            if ($request->has('search') && $request->query('search') != '') {
                $search = $request->query('search');
                $query->where('nama_yusuf', 'like', "%{$search}%")
                      ->orWhere('nip_yusuf', 'like', "%{$search}%")
                      ->orWhere('jabatan_yusuf', 'like', "%{$search}%")
                      ->orWhere('divisi_yusuf', 'like', "%{$search}%");
            }

            // Fitur Pagination via query params (?page=1&limit=10)
            $limit = $request->query('limit', 10); // Default limit 10 jika tidak diisi
            $pegawai = $query->paginate($limit);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diambil',
                'data' => $pegawai->items(),
                'pagination' => [
                    'page' => $pegawai->currentPage(),
                    'limit' => (int)$pegawai->perPage(),
                    'total' => $pegawai->total(),
                    'total_pages' => $pegawai->lastPage(),
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    /**
     * POST: Menambahkan data pegawai baru
     */
    public function store(Request $request)
    {
        try {
            // Validasi Input
            $validator = Validator::make($request->all(), [
                'nip_yusuf' => 'required|unique:pegawai_yusuf,nip_yusuf',
                'nama_yusuf' => 'required',
                'jabatan_yusuf' => 'required',
                'divisi_yusuf' => 'required',
                'tanggal_masuk_yusuf' => 'required|date',
            ], [
                'nip_yusuf.required' => 'NIP wajib diisi',
                'nip_yusuf.unique' => 'NIP sudah terdaftar',
                'nama_yusuf.required' => 'Nama wajib diisi',
                'jabatan_yusuf.required' => 'Jabatan wajib diisi',
                'divisi_yusuf.required' => 'Divisi wajib diisi',
                'tanggal_masuk_yusuf.required' => 'Tanggal masuk wajib diisi',
                'tanggal_masuk_yusuf.date' => 'Format tanggal masuk salah',
            ]);

            // Jika validasi gagal (422 Unprocessable Entity)
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Simpan Data
            $pegawai = Pegawai::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $pegawai
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    /**
     * GET {id}: Melihat detail satu data pegawai
     */
    public function show($id)
    {
        try {
            $pegawai = Pegawai::find($id);

            // Jika data tidak ditemukan (404 Not Found)
            if (!$pegawai) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diambil',
                'data' => $pegawai
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    /**
     * PUT/PATCH: Mengubah data pegawai berdasarkan ID
     */
    public function update(Request $request, $id)
    {
        try {
            $pegawai = Pegawai::find($id);

            if (!$pegawai) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Aturan validasi dinamis untuk PUT (wajib semua) vs PATCH (sebagian)
            $rules = [
                'nip_yusuf' => ($request->isMethod('patch') ? 'sometimes' : 'required') . '|unique:pegawai_yusuf,nip_yusuf,' . $id,
                'nama_yusuf' => $request->isMethod('patch') ? 'sometimes' : 'required',
                'jabatan_yusuf' => $request->isMethod('patch') ? 'sometimes' : 'required',
                'divisi_yusuf' => $request->isMethod('patch') ? 'sometimes' : 'required',
                'tanggal_masuk_yusuf' => ($request->isMethod('patch') ? 'sometimes' : 'required') . '|date',
            ];

            $validator = Validator::make($request->all(), $rules, [
                'nip_yusuf.required' => 'NIP wajib diisi',
                'nip_yusuf.unique' => 'NIP sudah terdaftar',
                'nama_yusuf.required' => 'Nama wajib diisi',
                'jabatan_yusuf.required' => 'Jabatan wajib diisi',
                'divisi_yusuf.required' => 'Divisi wajib diisi',
                'tanggal_masuk_yusuf.required' => 'Tanggal masuk wajib diisi',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update Data
            $pegawai->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $pegawai
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    /**
     * DELETE: Menghapus data pegawai
     */
    public function destroy($id)
    {
        try {
            $pegawai = Pegawai::find($id);

            if (!$pegawai) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $pegawai->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }
}