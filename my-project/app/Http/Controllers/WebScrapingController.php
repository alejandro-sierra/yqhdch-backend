<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;

class WebScrapingController extends Controller
{
    public function scraping()
    {
        $client = new Client();
        $url = "https://www.directoalpaladar.com/recetas-de-aperitivos/dip-espinacas-alcachofas-queso-receta-para-aportar-variedad-a-nuestros-aperitivos";

        $page = $client -> request("GET", $url);
        echo $page -> filter("h1")->text("hola");
        /* return view("scraping"); */
    }
}
