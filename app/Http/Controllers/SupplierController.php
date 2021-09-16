<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {

        $data = Supplier::all();

        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('action', function ($data) {
                    $button = '<button class="edit btn btn-warning" id="' . $data->id . '" name="edit">Edit</button>';
                    $button .= '<button class="delete btn btn-danger" id="' . $data->id . '" name="delete">Hapus</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('owner.supplier-home');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required|min:12|unique:suppliers,phone',
            'email' => 'required|unique:suppliers,email',
            'account_number' => 'required|unique:suppliers,account_number',
            'address' => 'required'
        ];

        $text = [
            'name.required' => 'Kolom nama tidak boleh kosong',
            'phone.required' => 'Kolom nohp tidak boleh kosong',
            'phone.unique' => 'No sudah terdaftar',
            'phone.min' => 'No sudah kurang dari 12 digit',
            'email.required' => 'Kolom email tidak boleh kosong',
            'email.unique' => 'Email sudah terdaftar',
            'account_number.required' => 'Kolom no.rekening tidak boleh kosong',
            'account_number.unique' => 'No.rekening sudah terdaftar',
            'address.required' => 'Kolom alamat tidak boleh kosong',
        ];

        $validasi = Validator::make($request->all(), $rules, $text);

        if ($validasi->fails()) {
            return response()->json(['success' => 0, 'text' => $validasi->errors()->first()], 422);
        }

        $save = Supplier::create($request->all());
        if ($save) {
            return response()->json(['text' => 'Data Berhasil Disimpan'], 200);
        } else {
            return response()->json(['text' => 'Data Gagal Disimpan'], 400);
        }
    }

    public function edit(Request $request)
    {

        $data = Supplier::find($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {

        $data = Supplier::find($request->id);
        $save = $data->update($request->all());

        if ($save) {
            return response()->json(['text' => 'Data Berhasil Diubah'], 200);
        } else {
            return response()->json(['text' => 'Data Gagal Diubah'], 400);
        }
    }

    public function delete(Request $request)
    {

        $data = Supplier::find($request->id);
        $save = $data->delete($request->all());

        if ($save) {
            return response()->json(['text' => 'Data Berhasil Dihapus'], 200);
        } else {
            return response()->json(['text' => 'Data Gagal Dihapus'], 400);
        }
    }
}
