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

    public function getShortcodeByShortcode($shortcode){
        return \DB::table('shorten')
            ->where('shortcode', $shortcode)
            ->select('shortcode')
            ->first();
    }

    public function ifShortcodeExists($shortcode){
        return \DB::table('shorten')
            ->where('shortcode', $shortcode)
            ->exists();
    }

    public function incrementShorten($shortcode){
        \DB::table('shorten')
            ->where('shortcode', $shortcode)
            ->increment('redirectCount', 1);
    }

    public function updateRedirectShorten($shortcode, $lastSeenDate){
        $update = \DB::table('shorten')
            ->where('shortcode', $shortcode)
            ->update(['lastSeenDate' => $lastSeenDate]);
        $this->incrementShorten($shortcode);

        return $update;
    }

    public function addShorten($url, $shortcode, $startDate){
         \DB::table('shorten')
            ->insert(
              ['url' => $url, 'shortcode' => $shortcode, 'startDate' => $startDate]
            );

        return $this->getShortcodeByShortcode($shortcode);
    }

    public function getStatusShortcode($shortcode){
        return \DB::table('shorten')
            ->where('shortcode', $shortcode)
            ->select('startDate', 'lastSeenDate', 'redirectCount')
            ->first();
    }
}