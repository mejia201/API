<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NasaController extends Controller
{
    public function getNasaData(Request $request)
    {
        $apiKey = 'lKnPv8jXStvjQhTPZARSErbLhJC5zrj2qAK73An4'; 
        $count = $request->input('count', 20); // Obtiene el valor de count del request, o usa 20 si no está presente
        $apiUrl = "https://api.nasa.gov/planetary/apod?api_key={$apiKey}&count={$count}";

        $response = Http::get($apiUrl);

        return $response->json();
    }


    public function getNeoData(Request $request)
    {
        $startDate = $request->input('start_date', '2015-09-07');
        $endDate = $request->input('end_date', '2015-09-08');
        $apiKey = 'lKnPv8jXStvjQhTPZARSErbLhJC5zrj2qAK73An4';
        $apiUrl = "https://api.nasa.gov/neo/rest/v1/feed?start_date={$startDate}&end_date={$endDate}&api_key={$apiKey}";

        $response = Http::get($apiUrl);

        return $response->json();
    }
}
