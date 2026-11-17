<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BidanWhatsAppSeeder extends Seeder
{
    public function run()
    {
        $officialWhatsApp = '6281224841377';

        // Check if Bidan Nurhayati exists
        $existing = $this->db->table('bidan')
            ->where('username', 'bidan_bunanur')
            ->get()
            ->getRowArray();

        if ($existing) {
            $data = ['whatsapp' => $officialWhatsApp];
            if ($this->db->fieldExists('no_hp', 'bidan')) {
                $data['no_hp'] = $officialWhatsApp;
            }
            $this->db->table('bidan')
                ->where('username', 'bidan_bunanur')
                ->update($data);

            echo "✓ Berhasil memperbarui nomor WhatsApp resmi Bidan Nurhayati ke {$officialWhatsApp} (+62 812-2484-1377)\n";
        } else {
            $data = [
                'nama'      => 'Bidan Nurhayati, S.Keb.CHE',
                'username'  => 'bidan_bunanur',
                'password'  => password_hash('BidanBunanur2026!', PASSWORD_BCRYPT, ['cost' => 12]),
                'whatsapp'  => $officialWhatsApp,
                'email'     => 'bunanurclinic@gmail.com',
                'alamat'    => 'Dusun Senen RT 004 / RW 002 Desa Kaduagung',
                'spesialis' => 'Bidan Praktik Mandiri & Mom-Baby Spa',
                'status'    => 'offline',
            ];
            if ($this->db->fieldExists('no_hp', 'bidan')) {
                $data['no_hp'] = $officialWhatsApp;
            }
            $this->db->table('bidan')->insert($data);

            echo "✓ Akun resmi Bidan Nurhayati berhasil dibuat dengan nomor WhatsApp {$officialWhatsApp}\n";
        }
    }
}
