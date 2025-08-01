<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait DatabaseRestrictionHelper {

    public function can_save( $model ) {
        
         $basename = class_basename( $model );

         $max = config('limits.'. Str::of( $basename )->plural()->lower(). '.max');
         //dd($max, $);
         if( $model::count() >= (int) $max ){
            return $this->handle_failure(false);
         }

         return $this->handle_failure(true);
    }

    public function handle_failure ( $success ) {
         if( !$success ) {
              throw new \Exception('Limit exceeded.');
         }
    }
}