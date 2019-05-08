<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Library\PaladinsApi;
use Illuminate\Support\Carbon;

class Player extends Model
{
    public $incrementing = false;

    public function fetchData()
    {
        $api = PaladinsApi::instance();
        if ($data = $api->getPlayerById($this->id)) {
            $this->name = $data['Name'];
//            $this->inGameRegister = Carbon::createFromFormat('', $data['Created_DateTime'])
//            $this->lastLogin = $data['Last_Login_Datetime'];
            $this->hoursPlayed = $data['HoursPlayed'];
            $this->level = $data['Level'];
            $this->losses = $data['Losses'];
            $this->wins = $data['Wins'];
            $this->leaves = $data['Leaves'];
            $this->region = $data['Region'];
            $this->touch();
            return true;
        }
        return false;
    }
}
