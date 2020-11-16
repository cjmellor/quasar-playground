<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameCollectionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function __invoke(Request $request)
    {
        return [
            'xbox' => [
                'The Witcher 3',
                'Cyberpunk 2077',
                'Assassin\'s Creed',
            ],
            'playstation' => [
                'Spider-Man',
                'God of War',
                'Final Fantasy VII Remake'
            ]
        ];
    }
}
