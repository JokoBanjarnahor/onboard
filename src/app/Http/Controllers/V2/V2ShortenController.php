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

    private $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_';

    // region for get all data
    public function getAll(Request $request, V2ShortenService $v2ShortenService){

        $data = $v2ShortenService->getAll();
        return response()->json($data);
    }
    // end region for get all data

    // region for add shortcode
    public function addShorten(Request $request, V2ShortenService $v2ShortenService)
    {
        // if it's json or not
        $data = $v2ShortenService->getAll();

        // get current date
        $startDate = date('c');

        // get url and shortcode parameter value
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

        if(!$this->checkRegex($shortcode)){
            return response()->json('The shortcode fails to meet the following regexp: ^[0-9a-zA-Z_]{4,}$.',
                HTTPStatus::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Remember add handler to check if the
        // input shortcode meet the reguirement regex

        if ($shortcode == '' || $data->contains('shortcode', $shortcode)){

            $shortcode = $this->generateShortcode();

            while($data->contains('shortcode', $shortcode)){
                $shortcode = $this->generateShortcode();
            }
        }

        $hasil = $v2ShortenService->addShorten($url, $shortcode, $startDate);

        return response()->json($hasil, HTTPStatus::HTTP_CREATED);
    }
    // end region add shortcode

    // region for redirect url by shortcode
    public function getByShortcode($shortcode, Request $request, V2ShortenService $v2ShortenService){

        $currentDate = date('c');

        $data = $v2ShortenService->getByShortcode($shortcode);

        if (empty($data)){
            return response()->json('The shortcode cannot be found in the system', HTTPStatus::HTTP_NOT_FOUND);
        }

        $v2ShortenService->updateRedirectShorten($shortcode, $currentDate);

        return response(redirect($data->url), HTTPStatus::HTTP_FOUND);
    }
    // end region for redirect url by shortcode

    // region for get status by shortcode
    public function getStatusByShortcode($shortcode, Request $request, V2ShortenService $v2ShortenService){

        $data = $v2ShortenService->getAll();
        $statusData = $v2ShortenService->getStatusByShortcode($shortcode);

        if ($data->contains('shortcode', $shortcode)){
            // change date format to ISO 8601
            $startDate = new \DateTime($statusData->startDate);
            $lastSeenDate = new \DateTime($statusData->lastSeenDate);

            // set date with changed date format
            $statusData->startDate = $startDate->format('c');
            $statusData->lastSeenDate = $lastSeenDate->format('c');
        } else {
            return response()->json('The shortcode cannot be found in the system',
                HTTPStatus::HTTP_NOT_FOUND);
        }

        return response()->json($statusData);
    }
    // end region for get status by shortcode

    // region for generate shortcode
    private function generateShortcode(){
        return substr(str_shuffle($this->characters), 0, 6);
    }
    // end region for generate shortcode

    // region for validate shortcode meet the regex requirement
    private function checkRegex($shortcode){
        $regex = '/^[0-9a-zA-Z_]{6}$/';

        return boolval(preg_match($regex, $shortcode));
    }
    // end of region for validate shortcode meet the regex requirement

}