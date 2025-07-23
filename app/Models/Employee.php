<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Designation;

use App\Helpers\SupabaseStorageHelper;

class Employee extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [];


    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function photoUrl(){
        if( !$this->photo )
        {
            return null;
        }
        $photoinfo = json_decode($this->photo, true);

        if( !isset($photoinfo['Key']) ){
            return null;
        }

        return SupabaseStorageHelper::publicUrl($photoinfo['Key']);
    }
}
