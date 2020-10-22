<?php

namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Psr7;

class Api extends Model
{
    use HasFactory;
    const API_KEY = '410c96f6288b472ba839e71aee3faffd';
    public function getNews($source){
        $content = [];
        try {
            $client = new Client();
            $apiRequest = $client->request('GET', 'https://newsapi.org/v1/articles?source='.$source.'&sortBy=top&apiKey='.self::API_KEY);
            $content = json_decode($apiRequest->getBody()->getContents(), true);
            return $content['articles'];
        }catch (RequestException $e){
            echo Message::toString($e->getRequest());
            if($e->hasResponse()){
                Message::toString($e->getResponse());
            }
        }
        return $content;
    }

    public function getAllSources(){
        try {
            $client = new Client();
            $apiRequest = $client->request('GET', 'https://newsapi.org/v1/sources?language=en');
            $content = json_decode($apiRequest->getBody()->getContents(), true);
            return $content['sources'];
        }catch (RequestException $e){
            echo Message::toString($e->getRequest());
            if($e->hasResponse()){
                echo Message::toString($e->getResponse());
            }
        }
        return [];
    }
}
