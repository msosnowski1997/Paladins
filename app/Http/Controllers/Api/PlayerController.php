<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Player;

class PlayerController extends Controller
{
    public function index($id)
    {
        $player = Player::find($id);
        if(!$player)
        {
            $player = new Player;
            $player->id = $id;
            $player->fetchData();
        }
//        else if($player->updated_at->timestamp  < now()-5*60 )
//        {
//            $player->fetchData();
//        }

        return response()->json($player);
    }

    public function battleLog($id)
    {

    }
}
