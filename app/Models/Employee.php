<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Designation;

class Employee extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [];


    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
