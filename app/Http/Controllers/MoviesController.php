<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    private $url = 'https://api.themoviedb.org/3/';
    private $token;

    public function __construct()
    {
        $this->token = config('services.tmdb.token');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $popularMovies = Http::withToken($this->token)
            ->get($this->url . 'movie/popular')
            ->json()['results'];
        $genresMovies = Http::withToken($this->token)
            ->get($this->url . 'genre/movie/list')
            ->json()['genres'];
        $nowPlayingMovies =  Http::withToken($this->token)
            ->get($this->url . 'movie/now_playing')
            ->json()['results'];

        $genres = collect($genresMovies)->mapWithKeys(function ($genre) {
            return [$genre['id'] => $genre['name']];
        });

        return view('index', compact(['popularMovies', 'genres', 'nowPlayingMovies']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Http::withToken($this->token)
            ->get($this->url . 'movie/' . $id . '?append_to_response=credits,images,videos')
            ->json();
        return view('show', compact(['movie']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
