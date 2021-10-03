<?php

namespace App\Http;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class MarvelApiClient
{
    private const URL = 'https://gateway.marvel.com/v1/public/characters';

    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getHeroes()
    {
        $apiKey = $_ENV['MARVEL_PUBLIC_KEY'];

        $limit = 100;
        $offset = 0;
        $total = null;
        $results = [];

        $ts = time();
        $hash = md5($ts . $_ENV['MARVEL_PRIVATE_KEY'] . $apiKey);

        do {
            $response = $this->httpClient->request('GET', self::URL, [
                'query' => [
                    'ts' => $ts,
                    'apikey' => $apiKey,
                    'hash' => $hash,
                    'offset' => $offset,
                    'limit' => $limit,
                ]
            ]);

            // @todo Handle Non 200 responses

            $data = json_decode($response->getContent())->data;
            $offset += count($data->results);
            $total = $data->total;
            array_push($results, ...$data->results);
        } while ($offset < $total);
        dump(count($results));
        return $results;
    }
}
