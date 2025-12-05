<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    public function up()
    {
        // Step 1: First change to VARCHAR to avoid ENUM issues
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE media MODIFY COLUMN section VARCHAR(255) NOT NULL DEFAULT 'other'");
        }

        // Step 2: Check what values actually exist
        $existingSections = DB::table('media')
            ->select('section')
            ->distinct()
            ->pluck('section')
            ->toArray();

        Log::info('Existing sections before cleanup:', ['sections' => $existingSections]);

        // Step 3: Clean up data - convert invalid sections to 'other'
        $validSections = ['features', 'aktivitas', 'hero', 'story', 'other'];

        DB::table('media')
            ->whereNotIn('section', $validSections)
            ->orWhereNull('section')
            ->orWhere('section', '')
            ->update(['section' => 'other']);

        // Step 4: Optional - change back to ENUM if needed
        // Hapus atau comment bagian ini jika ingin tetap menggunakan VARCHAR
        // DB::statement("ALTER TABLE media MODIFY COLUMN section ENUM('features', 'aktivitas', 'hero', 'story', 'other') NOT NULL DEFAULT 'other'");

        // Log final state
        $finalSections = DB::table('media')
            ->select('section')
            ->distinct()
            ->pluck('section')
            ->toArray();

        Log::info('Final sections after migration:', ['sections' => $finalSections]);
    }

    public function down()
    {
        // For rollback, just keep as VARCHAR or revert to previous state
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE media MODIFY COLUMN section VARCHAR(255) NOT NULL DEFAULT 'other'");
        }
    }
};
