<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorCounter extends Model
{
    protected $table = 'visitor_counter';

    protected $fillable = ['count', 'date'];

    // Tidak perlu relationship, migration, atau apa pun
    // Model sangat sederhana!
}
