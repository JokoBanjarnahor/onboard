<?php
/**
 * Created by PhpStorm.
 * User: Joko
 * Date: 25/03/19
 * Time: 9:46
 */
namespace App\Services\V2;


use App\Repositories\V2\V2ShortenRepository;
use App\Services\Service;

class V2ShortenService extends Service
{

    private $v2ShortenRepository;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->v2ShortenRepository = new V2ShortenRepository();
    }

    /**
     * @param $id
     * @param $data
     * @return int
     */

    public function getAll(){
        $allData = $this->v2ShortenRepository->getAll();
        return $allData;
    }

    public function getByShortcode($shortcode){
        $dataByShortcode = $this->v2ShortenRepository->getByShortcode($shortcode);
        return $dataByShortcode;
    }

    public function addShorten($url, $shortcode, $startDate){
        $shorten = $this->v2ShortenRepository->addShorten($url, $shortcode, $startDate);
        return $shorten;
    }

    public function getStatusByShortcode($shortcode){
        $status = $this->v2ShortenRepository->getStatusShortcode($shortcode);
        return $status;
    }
}