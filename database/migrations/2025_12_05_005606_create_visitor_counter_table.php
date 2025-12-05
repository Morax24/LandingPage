<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visitor_counter', function (Blueprint $table) {
            $table->id();
            $table->integer('count')->default(0);
            $table->date('date')->unique();
            $table->timestamps();
        });

        // Insert data untuk hari ini dan kemarin
        DB::table('visitor_counter')->insert([
            [
                'count' => 0,
                'date' => today(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'count' => 0,
                'date' => today()->subDay(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('visitor_counter');
    }
};
