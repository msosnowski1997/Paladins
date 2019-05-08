<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\PaladinsApi;

class test extends Controller
{
    public function index()
    {

        $api = PaladinsApi::instance();


        echo '<pre>';
//        print_r($api->getPlayerIdByName('Giverus'));
//        print_r($api->getPlayerStatus(7988170));
//        print_r($api->getPlayerById(7988170));
//
//        if(request('matchid'))
//            print_r($api->getMatchPlayerDetails(request('matchid')));
//        print_r($playerdata);
        print_r($api->getMatchDetailsBatch([822542941, 822548592, 822561663]));
//        print_r($api->getMatchDetails(824619828));
//        print_r($api->getGods());
//        print_r($api->getChampionCards(2277));
//        print_r($api->getChampionRanks(7988170));
//        print_r($api->getPlayerLoadOuts(7988170));
//        print_r($api->getDataUsed());
        echo '</pre>';
    }
}
