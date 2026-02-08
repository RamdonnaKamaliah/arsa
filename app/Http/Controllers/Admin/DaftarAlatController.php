<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\KategoriAlat;
use Exception;
use Illuminate\Http\Request;
use illuminate\Support\Str;

class DaftarAlatController extends Controller
{
    public function index(){
        return view('admin.data_alat.index');
    }

    public function create() {
        $kategori = KategoriAlat::all();
        return view('admin.data_alat.create', compact('kategori'));
    }

    public function store(Request $request){
        $request->validate([
            'id_kategori' => 'required|exists:kategori_alats,id',
            'nama_alat' => 'string|required|max:150',
            'stok' => 'required|integer',
            'foto_alat' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $fotoPath = null;

        if($request->hasFile('foto_alat')){
            $fotoPath = $request->file('foto_alat')->store('alat', 'public');
        }

        try{
            Alat::create([
                'id_alat' => Str::uuid(),
                'nama_alat' => $request->nama_alat,
                'stok' => $request->stok,
                'foto_alat' => $fotoPath
            ]);

            return redirect()->route('admin.data-alat.index')->with('succes', 'data berhasil ditambah');
        }catch (\Exception $e){
            return back()->withInput()->with('error', 'gagal menyimpan data' . $e->getMessage());
        }
    }

    public function edit(String $id){
        $kategori = KategoriAlat::all();
        $alat = Alat::where('id', $id)->firstOrFail();
        
        return view('admin.data_alat.edit', compact('kategori', 'alat'));
    }

    public function update(Request $request, $id) {
        
    }


    
}