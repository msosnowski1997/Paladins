<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HiRezApiSession extends Model
{
    public static function getCurrent()
    {

        return DB::table('hi_rez_api_sessions')->latest()->first();
    }
}
