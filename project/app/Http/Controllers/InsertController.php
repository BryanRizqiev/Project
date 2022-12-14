<?php

namespace App\Http\Controllers;

use App\Models\Insert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class InsertController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        $datas = DB::table('inserts');
        if (!$r->search == '' || !$r->search_rm == '') {
            if ($r->search_rm  == '') {
                $src = '%' . trim(strtolower($r->search)) . '%';
                $datas = DB::table('inserts')->where('nama', 'like', $src)
                    ->paginate(15);
            }
            if ($r->search != '' && $r->search_rm != '') {
                $src = '%' . trim(strtolower($r->search)) . '%';
                $datas = DB::table('inserts')->where('nama', 'like', $src)->where('no_rekam_medis', $r->search_rm)
                    ->paginate(15);
            }
            if ($r->search  == '') {
                $datas = DB::table('inserts')->where('no_rekam_medis', $r->search_rm)
                    ->paginate(15);
            }
        } else {
            $datas = DB::table('inserts')->paginate(25);
        }

        // $datas->paginate(3);
        // if (request('search')) {
        //     $src = '%' . trim(strtolower(request('search'))) . '%';
        //     $datas = DB::table('inserts')->where('nama', 'like', $src)->paginate(25);
        // } else {
        //     $datas = DB::table('inserts')->paginate(25);
        // }
        return view('pages.dashboard', compact('datas'));
    }

    public function store(Request $r)
    {
        try {
            $r->validate([
                'no_bpjs' => ['unique:inserts']
            ]);
            Insert::create([
                'nama' => $r->nama,
                'tanggal_lahir' => $r->tanggal_lahir,
                'no_bpjs' => $r->no_bpjs,
                'aktif' => filter_var($r->aktif, FILTER_VALIDATE_BOOLEAN),
                'status_bpjs' => $r->status_bpjs,
                'no_ktp' => $r->no_ktp,
                'nama_provider' => $r->nama_provider,
                'no_rekam_medis' => $r->no_rekam_medis
            ]);
        } catch (Throwable $th) {
            return back()->with('fail', 'Gagal ditambahkan');
        }

        return back()->with('success', 'Berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $data = Insert::findOrFail($id);
        $data->delete();

        return back();
    }

    public function updateAllData()
    {
        $datas = DB::table('inserts')->get(['id', 'no_bpjs']);
        // Log::info('Start');
        foreach ($datas as $data) {
            try {
                // Log::info('Endpoint start');
                $result = Http::get('http://kkn.lp2m.unpkediri.ac.id/laporan/2015/api/bpjs.php?nobpjs=' . $data->no_bpjs);
                // Log::info('Endpoint end');
            } catch (Throwable $th) {
                return response()->json([
                    'success' => false 
                ], 400);
            }
            // Log::info('Store db');
            $dataUpdate = Insert::findOrFail($data->id);
            $dataUpdate->aktif = $result['response']['aktif'];
            $dataUpdate->save();
            // Log::info('Success');
        }
        // Log::info('End');
        return response()->json([
            'success' => true 
        ], 200);
    }

    public function update(Request $r)
    {
        try {
            $data = Insert::findOrFail($r->id);
            $data->no_rekam_medis = $r->no_rekam_medis;
            $data->save();
        } catch (Throwable $th) {
            return back()->with('fail', 'Gagal diupdate');
        }

        return back()->with('success', 'Berhasil diupdate');
    }

    public function statistic()
    {
        $datas = DB::table('inserts')->get();

        return view('pages.statistic', [
            'count' => $datas->count(),
            'active' => $datas->where('aktif', true)->count(),
            'nonactive' => $datas->where('aktif', false)->count(),
        ]);
    }
}
