<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'siswa',
            'url_menu' => [
                'url' => route('siswa'),
                'url_json' => route('siswa.json_data'),
            ],
            'breadcrumb' => [
                [
                    'name' => 'siswa',
                    'url' => route('siswa'),
                    'active' => true,
                ],
            ]
        ];
        return view('pages.siswa', $data);
    }

    public function getData()
    {
        $siswaList = Siswa::all();
        $data = [];
        $no = 1;

        foreach ($siswaList as $siswa) {
            $btn_edit = '<a href="javascript:void(0);" class="btn btn-warning btn-edit" data-id="'. $siswa->id .'">Edit</a>';
            $btn_hapus = '<a href="javascript:void(0);" data-id="'. $siswa->id .'" class="btn btn-danger btn-delete">Hapus</a>';

            $data[] = [
                $no++,
                $siswa->nisn,
                $siswa->nama,
                $siswa->jk,
                $siswa->kelas_id,
                $btn_edit . ' ' . $btn_hapus,
            ];
        }

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'data siswa berhasil ditemukan',
        ], 200, ['Content-Type' => 'application/json; charset=utf-8'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function getDataById($id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) {
            return response()->json([
                'status' => false,
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $siswa,
            'message' => 'data berhasil ditemukan',
        ], 200);
    }

    public function insertData(Request $request)
    {
        $data = $request->only(['nisn', 'nama', 'jk', 'kelas_id']);

        $validator = Validator::make($data, [
            'nisn' => ['required', 'unique:siswa', 'max:10'],
            'nama' => ['required', 'min:3', 'max:255'],
            'jk' => ['required', 'in:L,P'],
            'kelas_id' => ['required', 'integer'],
        ], [
            'required' => ':attribute tidak boleh kosong.',
            'unique' => ':attribute sudah digunakan.',
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal :max karakter.',
            'in' => ':attribute harus bernilai L atau P.',
            'integer' => ':attribute harus berupa angka.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        }

        Siswa::create($data);

        return response()->json([
            'status' => true,
            'message' => 'data berhasil ditambahkan',
        ], 201);
    }

    public function updateData(Request $request, $id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) {
            return response()->json([
                'status' => false,
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        $data = $request->only(['nisn', 'nama', 'jk', 'kelas_id']);

        $validator = Validator::make($data, [
            'nisn' => ['required', 'max:10', 'unique:siswa,nisn,' . $siswa->id],
            'nama' => ['required', 'min:3', 'max:255'],
            'jk' => ['required', 'in:L,P'],
            'kelas_id' => ['required', 'integer'],
        ], [
            'required' => ':attribute tidak boleh kosong.',
            'unique' => ':attribute sudah digunakan.',
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal :max karakter.',
            'in' => ':attribute harus bernilai L atau P.',
            'integer' => ':attribute harus berupa angka.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $siswa->update($data);

        return response()->json([
            'status' => true,
            'message' => 'data berhasil diubah',
        ], 200);
    }

    public function deleteData($id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) {
            return response()->json([
                'status' => false,
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        $siswa->delete();

        return response()->json([
            'status' => true,
            'message' => 'data berhasil dihapus',
        ], 200);
    }
}