<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insert extends Model
{
    use HasFactory;
    
    protected $fillable = ['nama', 'tanggal_lahir', 'no_bpjs', 'status_bpjs', 'no_ktp', 'aktif', 'nama_provider', 'no_rekam_medis'];
}
