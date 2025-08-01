<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Employee;

class Attendance extends Model
{
    //
    // use SoftDeletes; 

    protected $fillable = [];

    // protected $casts = [
    //     'check_in'  => 'datetime:H:i',
    //     'check_out' => 'datetime:H:i'
    // ];

    protected function checkIn(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value? join(':', array_slice(explode(':',$value),0,2)): null
        );
    }

    protected function checkOut(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value? join(':', array_slice(explode(':',$value),0,2)): null
        );
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
