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
//            ->select('url', 'shortcode')
            ->get();
    }

    public function addShorten($url, $shortcode){
        \DB::table('shorten')
            ->insert(
              ['url' => $url, 'shortcode' => $shortcode]
            );

        return $shortcode;
    }
}