<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriBerandaModel extends Model
{
    protected $table = 'galeri_beranda';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'tipe',
        'file_name',
        'judul',
        'urutan',
        'waktu_unggah'
    ];
}