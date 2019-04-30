<?php

namespace Finagin\CertBotCloudFlare;

class CloudFlare
{
    public const DELETE = 2;
    public const POST = 1;
    public const GET = 0;

    /**
     * @var \Finagin\CertBotCloudFlare\CloudFlare
     */
    private static $instance;

    private $login;
    private $token;

    private $domain = 'https://api.cloudflare.com/client/v4/zones/';


    final private function __construct(string $login, string $token, string $zone)
    {
        $this->login = $login;
        $this->token = $token;
        $this->domain .= $zone.'/';
    }

    final public static function init(string $login, string $token, string $zone): CloudFlare
    {
        if (self::$instance === null) {
            self::$instance = new static($login, $token, $zone);
        }

        return self::$instance;
    }

    public static function post(string $api_method, array $data = []): array
    {
        return self::$instance->api(static::POST, $api_method, $data);
    }

    protected function api(int $method, string $api_method, array $data = []): array
    {
        $query = '';
        $url = $this->domain.$api_method;
        $curl = curl_init();

        switch ($method) {
            case static::GET:
                $query = '?'.http_build_query($data);
                break;
            case static::POST:
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case static::DELETE:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        curl_setopt($curl, CURLOPT_URL, $url.$query);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-Auth-Key: '.$this->token,
            'X-Auth-Email:'.$this->login,
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    public static function get(string $api_method, array $data = []): array
    {
        return self::$instance->api(static::GET, $api_method, $data);
    }

    public static function delete(string $api_method, array $data = []): array
    {
        return self::$instance->api(static::DELETE, $api_method, $data);
    }
}
