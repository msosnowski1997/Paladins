<?php

namespace App\Model;

use App\Library\PaladinsApi;
use Illuminate\Database\Eloquent\Model;
use App\Model\Player;

class Match extends Model
{
    public $incrementing = false;

    public static function byPlayer($player, int $page = 1, int $perPage = 10)
    {
        if ($player instanceof Player)
            $playerId = $player->id;
        else
            $playerId = $player;

        if ($page < 1) $page = 1;
        if ($perPage < 1) $perPage = 1;

        $matches = Match::where('player1_1', $playerId)
            ->orWhere('player1_2', $playerId)
            ->orWhere('player1_3', $playerId)
            ->orWhere('player1_4', $playerId)
            ->orWhere('player1_5', $playerId)
            ->orWhere('player2_1', $playerId)
            ->orWhere('player2_2', $playerId)
            ->orWhere('player2_3', $playerId)
            ->orWhere('player2_4', $playerId)
            ->orWhere('player2_5', $playerId)
            ->orderBy('id', 'desc')
            ->skip(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        return $matches;
    }

    public static function fetchPlayerMatches(Player $player)
    {
        $api = PaladinsApi::instance();

        $lastMatch = Match::byPlayer($player, 1, 1);

        $data = $api->getMatchHistory($player->id);

        $matchesIds = [];

        foreach (array_reverse($data) as $match)
        {
            if ($lastMatch->entryTime >= $match['EntryTime']) continue;

            $matchesIds[] = $match['Match'];
        }

        $matchesIdsChunks = array_chunk($matchesIds, 10);

        foreach ($matchesIdsChunks as $chunk)
        {
            $matches = $api->getMatchDetailsBatch($chunk);

            foreach ($matches as $match)
            {
//                Dodawanie meczu do bazy danych...
            }
        }
    }

    public static function addNewMatch(array $data)
    {
        $match = new Match;

        $match->id = $data['Match'];

//        Dodawanie informacji ogólnych o meczu

        $match->map = $data[0]['Map_Game'];
//        Przygotowywanie tablicy z informacjami o meczu...
        $mi = []; // matchInfo
        $mi['banId1'] = $match[0]['BanId1'];
        $mi['banId2'] = $match[0]['BanId2'];
        $mi['banId3'] = $match[0]['BanId3'];
        $mi['banId4'] = $match[0]['BanId4'];
        $mi['banChampionName1'] = $match[0]['Ban_1'];
        $mi['banChampionName2'] = $match[0]['Ban_2'];
        $mi['banChampionName3'] = $match[0]['Ban_3'];
        $mi['banChampionName4'] = $match[0]['Ban_4'];



        foreach ($data as $i => $record)
        {
            if($i < count($data)/2)
                $column = 'player1_'.($i+1);
            else
                $column = 'player2_'.($i+1-count($data)/2);

            $match->$column = $record['ActivePlayerId'];
            $column .= '_info';

//            Przygotowywanie tablicy z informacjami...
            $pi = []; // playerInfo
            $pi['itemId1'] = $record['ActiveId1'];
            $pi['itemId2'] = $record['ActiveId2'];
            $pi['itemId3'] = $record['ActiveId3'];
            $pi['itemId4'] = $record['ActiveId4'];
            $pi['itemLevel1'] = $record['ActiveLevel1'];
            $pi['itemLevel2'] = $record['ActiveLevel2'];
            $pi['itemLevel3'] = $record['ActiveLevel3'];
            $pi['itemLevel4'] = $record['ActiveLevel4'];
            $pi['championId'] = $record['ChampionId'];
            $pi['championName'] = $record['Reference_Name'];


        }
    }
}


