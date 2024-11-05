<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parameter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'parameter';

    protected $guarded = [];

    public function monitorings()
    {
        return $this->hasMany(Monitoring::class);
    }
}
