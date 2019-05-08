<?php

namespace App\Library;


class PaladinsApi extends PaladinsApiCore
{
    public function getPlayerIdByName($name)
    {
        $url = $this->prepareUrl('getplayeridbyname', [$name]);
        return $this->callApi($url);
    }

    public function getPlayerById($id)
    {
        $url = $this->prepareUrl('getplayer', [$id]);
        $data = $this->callApi($url);
        if ($data[0]['Id'] == $id)
            return $data[0];
        else
            return null;
    }

    public function getPlayerStatus($id)
    {
        $url = $this->prepareUrl('getplayerstatus', [$id]);
        return $this->callApi($url);
    }


    public function getMatchHistory($id)
    {
        $url = $this->prepareUrl('getmatchhistory', [$id]);
        return $this->callApi($url);
    }

    public function getMatchDetails($match)
    {
        $url = $this->prepareUrl('getmatchdetails', [$match]);
        return $this->callApi($url);
    }

    public function getMatchDetailsBatch($matches)
    {
        $url = $this->prepareUrl('getmatchdetailsbatch');
        if (is_array($matches))
        {
            $url .= '/' . implode(',', $matches);
        }
        $data = [];
        foreach ($this->callApi($url) as $record)
        {
            $data[$record['Match']][] = $record;
        }
        return $data;
    }

    public function getMatchPlayerDetails($match)
    {
        $url = $this->prepareUrl('getmatchplayerdetails', [$match]);
        return $this->callApi($url);
    }

    public function getChampions($lang = 12)
    {
        $url = $this->prepareUrl('getchampions', [$lang]);
        return $this->callApi($url);
    }

    public function getChampionCards($champion, $lang = 12)
    {
        $url = $this->prepareUrl('getchampioncards', [$champion, $lang]);
        return $this->callApi($url);
    }

    public function getChampionRanks($id)
    {
        $url = $this->prepareUrl('getchampionranks', [$id]);
        return $this->callApi($url);

    }

    public function getPlayerLoadOuts($id, $lang = 12)
    {
        $url = $this->prepareUrl('getplayerloadouts', [$id, $lang]);
        return $this->callApi($url);
    }

    public function getDataUsed()
    {
        $url = $this->prepareUrl('getdataused');
        return $this->callApi($url);
    }

}
