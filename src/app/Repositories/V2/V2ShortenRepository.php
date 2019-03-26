<?php
/**
 * Created by PhpStorm.
 * User: Joko
 * Date: 24/03/19
 * Time: 23:23
 */
namespace App\Repositories\V2;

use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class V2ShortenRepository extends Repository {

    public function getAll(){
        return \DB::table('shorten')
            ->get();
    }

    public function getByShortcode($shortcode){
        return \DB::table('shorten')
            ->where('shortcode', $shortcode)
            ->first();
    }

    public function ifShortcodeExists($shortcode){
        return \DB::table('shorten')
            ->where('shortcode', $shortcode)
            ->exists();
    }

    public function addShorten($url, $shortcode){
        return \DB::table('shorten')
            ->insert(
              ['url' => $url, 'shortcode' => $shortcode]
            );

        return $shortcode;
    }
}