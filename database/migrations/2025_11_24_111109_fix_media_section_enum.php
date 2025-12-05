<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Simply convert the column to VARCHAR permanently
        // This avoids all ENUM-related issues
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE media MODIFY COLUMN section VARCHAR(255) NOT NULL DEFAULT 'other'");
        }

        // Clean up any remaining invalid data
        DB::table('media')
            ->whereNull('section')
            ->orWhere('section', '')
            ->update(['section' => 'other']);
    }

    public function down()
    {
        // On rollback, keep as VARCHAR for safety
        // Or change back to previous ENUM if you're sure about the values
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE media MODIFY COLUMN section VARCHAR(255) NOT NULL DEFAULT 'other'");
        }
    }
};
