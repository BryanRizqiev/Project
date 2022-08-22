<?php

namespace App\Http\Controllers;

use App\Models\Insert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if (request('search')) {
            $src = '%' . trim(strtolower(request('search'))) . '%';
            $datas = DB::table('inserts')->where('nama', 'like', $src)->paginate(25);
        } else {
            $datas = DB::table('inserts')->paginate(25);
        }
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

    // public function search(Request $r)
    // {
    //     $datas = DB::table('inserts')->where('nama', 'LIKE', '%' . $r->search . '%');
    //     return view('pages.dashboard', compact('datas')); 
    // }

    public function statistic()
    {
        $datas = DB::table('inserts')->get();
        
        return view('pages.profile', [
            'count' => $datas->count(),
            'active' => $datas->where('status_bpjs', 'AKTIF')->count(),
            'nonactive' => $datas->where('status_bpjs', 'NONAKTIF')->count(),
        ]);
    }
}
