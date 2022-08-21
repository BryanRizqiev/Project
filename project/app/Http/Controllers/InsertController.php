<?php

namespace App\Http\Controllers;

use App\Models\Insert;
use Illuminate\Http\Request;
use Throwable;

class InsertController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Insert::all();
        return view('pages.dashboard', compact('datas')); 
    }

    public function store(Request $r)
    {
        try {            
            Insert::create([
                'nama' => $r->nama,
                'tanggal_lahir' => $r->tanggal_lahir,
                'no_bpjs' => $r->no_bpjs,
                'status_bpjs' => $r->status_bpjs,
                'no_ktp' => $r->no_ktp,
                'nama_provider' => $r->nama_provider,
                'no_rekam_medis' => $r->no_rekam_medis
            ]);
        } catch (Throwable $th) {
            return back();
        }

        return back();
    }

    public function destroy($id)
    {
        $data = Insert::findOrFail($id);
        $data->delete();

        return back();
    }
}
