<?php
/**
 * Created by PhpStorm.
 * User: Joko
 * Date: 25/03/19
 * Time: 10:00
 */

namespace App\Http\Controllers\V2;


use App\Constants\HTTPStatus;
use Illuminate\Support\Collection;
use App\Services\V2\V2ShortenService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class V2ShortenController extends Controller
{

    public function getAll(Request $request, V2ShortenService $v2ShortenService){

        $data = $v2ShortenService->getAll();
        return response()->json($data);
    }

    public function addShorten(Request $request, V2ShortenService $v2ShortenService)
    {
        // if it's json or not
        // use database isShortcodeexist
        $data = $v2ShortenService->getAll();

        //var_dump($allData->contains('shortcode', '789asd'));
        $url = $request->json()->get('url');
        $shortcode = $request->json()->get('shortcode');

        if($url == ''){
            return response()->json('URL is not present',
                HTTPStatus::HTTP_BAD_REQUEST);
        }

        if($data->contains('shortcode', $shortcode)) {
            return response()->json('The desired shortcode is already in use',
                HTTPStatus::HTTP_CONFLICT);
        }

        // Remember add handler to check if the
        // input shortcode meet the reguirement regex

        if ($shortcode == '' || $data->contains('shortcode', $shortcode)){
            // put generated shortcode here and date dont forget
            $shortcode = $this->generateShortcode();

            while($data->contains('shortcode', $shortcode)){
                $shortcode = $this->generateShortcode();
            }
        }

        $hasil = $v2ShortenService->addShorten($url, $shortcode);

        return response()->json($hasil, HTTPStatus::HTTP_CREATED);
    }

    public function getByShortcode($shortcode, Request $request, V2ShortenService $v2ShortenService){

        $data = $v2ShortenService->getByShortcode($shortcode);
//        var_dump($data);
        if (empty($data)){
            return response()->json('The shortcode cannot be found in the system', HTTPStatus::HTTP_NOT_FOUND);
        }

        return response(redirect($data->url), HTTPStatus::HTTP_FOUND);
    }

    private function generateShortcode(){

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_';

        return substr(str_shuffle($characters), 0, 6);
    }


}