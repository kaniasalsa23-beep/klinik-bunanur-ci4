<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: CreatePasswordResetsTable
 *
 * Creates the `password_resets` table used for the dual enterprise-grade
 * cryptographic Forgot Password flow (Bidan & Pasien).
 *
 * Security Design:
 * - Only SHA-256 digests of tokens/OTPs are stored (never plaintext).
 * - expires_at enforces a strict 15-minute TTL.
 * - used_at ensures single-use tokens (replay-attack prevention).
 * - attempts limits brute-force OTP guessing (max 5 per token).
 */
class CreatePasswordResetsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_type' => [
                'type'       => 'ENUM',
                'constraint' => ['bidan', 'pasien'],
                'null'       => false,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
            ],
            // The identifier used to find the user (username or email)
            'identifier' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            // SHA-256 hash of the 64-char hex token (bin2hex(random_bytes(32)))
            'token_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '64',
                'null'       => false,
            ],
            // SHA-256 hash of the 6-digit OTP
            'otp_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '64',
                'null'       => false,
            ],
            // Number of OTP verification attempts (max 5 allowed)
            'attempts' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
                'unsigned'   => true,
                'default'    => 0,
            ],
            // Token expiry: 15 minutes from creation
            'expires_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            // Set when token is consumed; prevents replay attacks
            'used_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('token_hash'); // Fast token lookup
        $this->forge->addKey(['user_type', 'user_id']); // User reset history

        $this->forge->createTable('password_resets', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('password_resets', true);
    }
}
