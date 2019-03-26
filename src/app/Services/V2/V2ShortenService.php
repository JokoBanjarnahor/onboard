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
        return $this->v2ShortenRepository->getAll();
    }

    public function getByShortcode($shortcode){
        return $this->v2ShortenRepository->getByShortcode($shortcode);
    }

    public function addShorten($url, $shortcode){
        return $this->v2ShortenRepository->addShorten($url, $shortcode);
    }

}