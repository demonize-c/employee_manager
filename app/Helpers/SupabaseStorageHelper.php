<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SupabaseStorageHelper
{
    protected static function baseUrl()
    {
        return rtrim(env('SUPABASE_API_ENDPOINT'), '/').'/storage/v1/object';
    }

    // protected static function baseUrl()
    // {
    //     return rtrim(env('SUPABASE_API_ENDPOINT'), '/').'/storage/v1/object/'.env('SUPABASE_BUCKET');
    // }

    protected static function headers()
    {
        return [
            'apikey' => env('SUPABASE_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ];
    }

    public static function upload( $file , $path)
    {
        $response = Http::withHeaders(self::headers())
                    ->withBody($file->get(),'image/'.$file->extension())
                    ->post(self::baseUrl().'/'.env('SUPABASE_BUCKET').'/'.ltrim($path,'/'));

        if( $response->failed() ){
            throw new \Exception($response->body());
        }
        
        return $response->json();
    }

    // public static function update($path, $file)
    // {
    //     $response = Http::withHeaders(self::headers())
    //         ->attach('file', file_get_contents($file), $file->getClientOriginalName())
    //         ->post(self::baseUrl() . "/upload/resumable", [
    //             'bucketName' => env('SUPABASE_BUCKET'),
    //             'objectName' => $path,
    //             'upsert' => 'true',
    //         ]);
    //     if( $response->failed() ){
    //         throw new Exception($response->body());
    //     }

    //     return $response->object();
    // }

    public static function delete($path)
    {
        $response = Http::withHeaders(self::headers())
            ->delete(self::baseUrl() . '/' .ltrim($path, '/'));

        if( $response->failed() ){
            throw new \Exception($response->body());
        }
        
        return $response->json();
    }

    public static function publicUrl($path)
    {
        return env('SUPABASE_API_ENDPOINT') . "/storage/v1/object/public/".ltrim($path, '/');
    }
}

