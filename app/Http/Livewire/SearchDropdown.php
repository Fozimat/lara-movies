<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SearchDropdown extends Component
{
    public $search = '';
    private $token;

    public function __construct()
    {
        $this->token = config('services.tmdb.token');
    }

    public function render()
    {
        $searchResults = [];

        if (strlen($this->search > 2)) {
            $searchResults = Http::withToken($this->token)
                ->get('https://api.themoviedb.org/3/search/movie?query=' . $this->search)
                ->json()['results'];
        }

        return view('livewire.search-dropdown', [
            'searchResults' =>  collect($searchResults)->take(10)
        ]);
    }
}
