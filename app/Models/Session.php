<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table      = 'sessions';
    protected $primaryKey = 'id';
    public    $incrementing = false;
    protected $keyType    = 'string';
    public    $timestamps = false;

    protected $fillable = [
        'id',
        'child_id',
        'mode',
        'table_number',
        'correct_answers',
        'total_questions',
    ];
}
