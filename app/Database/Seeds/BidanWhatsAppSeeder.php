<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BidanWhatsAppSeeder extends Seeder
{
    public function run()
    {
        // Update WhatsApp number for Bidan Nurhayati (default admin)
        $this->db->table('bidan')
            ->where('username', 'bidan_bunanur')
            ->update(['whatsapp' => '081224841377']);

        echo "✓ Updated Bidan Nurhayati WhatsApp to 081224841377 (+62 812-2484-1377)\n";
    }
}
