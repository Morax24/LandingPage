// Buat file migration baru untuk menambah kolom price:
// database/migrations/2025_12_06_add_price_to_media_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->nullable()->after('section');
        });
    }

    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
