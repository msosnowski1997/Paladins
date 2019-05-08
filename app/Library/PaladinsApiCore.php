<?php

namespace App\Library;

use App\Model\HiRezApiSession;
use Illuminate\Support\Carbon;
use GuzzleHttp\Client;

class PaladinsApiCore
{
    private static $instance;

    private $devKey;
    private $authKey;
    private $session;
    private $endpoint;

    const ENDPOINT_PC = "http://api.paladins.com/paladinsapi.svc";
    const ENDPOINT_XBOX = "http://api.xbox.paladins.com/paladinsapi.svc";
    const ENDPOINT_PS4 = "http://api.ps4.paladins.com/paladinsapi.svc";


    public static function instance()
    {
        if(self::$instance === null)
        {
            self::$instance = new PaladinsApi();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->devKey = env("PALADINS_DEV_KEY");
        $this->authKey = env("PALADINS_AUTH_KEY");
        $this->setEndpoint('pc');
    }

    public function setEndpoint($endpoint)
    {
        switch($endpoint)
        {
            case "pc":
                $this->endpoint = PaladinsApi::ENDPOINT_PC;
                break;
            case "xbox":
                $this->endpoint = PaladinsApi::ENDPOINT_XBOX;
                break;
            case "ps4":
                $this->endpoint = PaladinsApi::ENDPOINT_PS4;
                break;
            default:
                return null;
        }
        return $this;
    }

    private function makeSignature($method)
    {
        return md5($this->devKey . $method . $this->authKey . gmdate("YmdHis"));
    }

    private function getSession()
    {
        if($this->session)
        {
            return $this->session;
        }

        $session = HiRezApiSession::getCurrent();
        if($session && $session->created_at > Carbon::now()->subMinutes(10))
        {
            $this->session = $session->hash;
        }
        else
        {
            $url = $this->endpoint . '/createsessionJson/'. $this->devKey .'/'. $this->makeSignature('createsession') .'/'. gmdate("YmdHis");
            $data = $this->callApi($url);
            unset($session);
            $session = new HiRezApiSession();
            $this->session = $session->hash = $data['session_id'];
            $session->touch();
        }
        return $this->session;
    }

    protected function prepareUrl($method, array $parameters = null)
    {
        $url =
            $this->endpoint.
            '/'.$method.'Json'.
            '/'.$this->devKey.
            '/'.$this->makeSignature($method).
            '/'.$this->getSession().
            '/'.gmdate("YmdHis");

        if($parameters)
        {
            foreach($parameters as $parameter)
            {
                $url .= '/'.$parameter;
            }
        }
        return $url;
    }



    protected function callApi($url)
    {
        $client = new Client;
        $options['headers'] = [
            'Accept' => 'application/json',
        ];
        $options['http_errors'] = false;

        try
        {
            $response = $client->get($url, $options );
        }
        catch(Exception $e)
        {

        }
        if($response->getStatusCode() == 200)
        {
            return json_decode($response->getBody(), true);
        }
        else
        {
            echo 'ERROR';
            echo $response->getStatusCode();
            echo '<pre>';
            echo json_decode($response->getBody(), true);
            echo '</pre>';
            echo 'Exit here!';
            exit;
        }
        return null;
    }

}
