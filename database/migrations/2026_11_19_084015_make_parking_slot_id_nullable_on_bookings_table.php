<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Trigger saat data baru masuk ke tabel bookings (Kendaraan Masuk)
        DB::unprepared('
            CREATE TRIGGER tr_bookings_after_insert
            AFTER INSERT ON `bookings`
            FOR EACH ROW
            BEGIN
                IF NEW.parking_slot_id IS NOT NULL THEN
                    UPDATE `parking_slots`
                    SET `status` = "occupied"
                    WHERE `id` = NEW.parking_slot_id;
                END IF;
            END
        ');

        // 2. Trigger saat data di tabel bookings diperbarui (Kendaraan Keluar / Selesai)
        DB::unprepared('
            CREATE TRIGGER tr_bookings_after_update
            AFTER UPDATE ON `bookings`
            FOR EACH ROW
            BEGIN
                IF NEW.parking_slot_id IS NOT NULL AND NEW.status IN ("completed", "finished", "selesai") THEN
                    UPDATE `parking_slots`
                    SET `status` = "available"
                    WHERE `id` = NEW.parking_slot_id;
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `tr_bookings_after_insert`');
        DB::unprepared('DROP TRIGGER IF EXISTS `tr_bookings_after_update`');
    }
};