<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\KategoriAlat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class DaftarAlatController extends Controller
{
    public function index(){
         $alat = Alat::with('kategori')->latest()->get();
        return view('admin.data_alat.index', compact('alat'));
    }

    public function create() {
        $kategori = KategoriAlat::all();
        return view('admin.data_alat.create', compact('kategori'));
    }

    public function show($id){
        $alat = Alat::where('id', $id)->firstOrFail();
        return view('admin.data_alat.show', compact('alat'));
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
                'id_kategori' => $request->id_kategori,
                'nama_alat' => $request->nama_alat,
                'stok' => $request->stok,
                'foto_alat' => $fotoPath
            ]);

            return redirect()->route('admin.data-alat.index')->with('success', 'data berhasil ditambah');
        }catch (\Exception $e){
            return back()->withInput()->with('error', 'gagal menyimpan data' . $e->getMessage());
        }
    }

    public function edit(String $id){
        $kategori = KategoriAlat::all();
        $alat = Alat::where('id', $id)->firstOrFail();
        
        return view('admin.data_alat.edit', compact('kategori', 'alat'));
    }

    public function update(Request $request, $id)
{
    $alat = Alat::findOrFail($id);

    $request->validate([
        'nama_alat' => 'required|string|max:255',
        'id_kategori' => 'required',
        'stok' => 'required|integer',
        'foto_alat' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // update data biasa
    $alat->nama_alat = $request->nama_alat;
    $alat->id_kategori = $request->id_kategori;
    $alat->stok = $request->stok;

    if ($request->hasFile('foto_alat')) {

        if ($alat->foto_alat && file_exists(public_path('storage/' . $alat->foto_alat))) {
            unlink(public_path('storage/' . $alat->foto_alat));
        }

        $foto = $request->file('foto_alat')->store('alat', 'public');
        $alat->foto_alat = $foto;
    }

    $alat->save();

    return redirect()->route('admin.data-alat.index')
        ->with('success', 'Data alat berhasil diupdate!');
}


    public function destroy($id) {
        $alat = Alat::where('id', $id)->firstOrFail();
        try {
            $alat->delete();
            return redirect()->route('admin.data-alat.index')->with('success', 'data berhasil dihapus');
        } catch (Exception $e) {
            return redirect()->route('admin.data-alat.index')->with('error', 'gagal menghapus data: ' . $e->getMessage());
        }
    }


    
}