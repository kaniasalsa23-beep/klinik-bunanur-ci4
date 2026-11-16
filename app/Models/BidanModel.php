<?php

namespace App\Models;

use CodeIgniter\Model;

class BidanModel extends Model
{
    protected $table = 'bidan';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

protected $allowedFields = [
    'nama',
    'username',
    'password',
    'foto',
    'hero_foto',
    'logo_hero',
    'email',
    'whatsapp',
    'alamat',
    'spesialis',
    'instagram',
    'facebook',
    'tiktok',
    'tentang',
    'hero_judul',
    'hero_subjudul',
    'deskripsi_beranda',
    'foto_tentang',
    'biografi',
    'visi_misi',
    'status',
    'last_seen'
];
}