<div class="relative mt-3 md:mt-0" x-data="{isOpen: true}" @click.away="isOpen = false">
    <input wire:model.debounce.500ms="search" type="text" @focus="isOpen = true" @keydown.escape.window="isOpen = false"
        @keydown.shift.tab="isOpen = false" @keydown="isOpen = true" x-ref="search"
        @keydown.window="if(event.keyCode === 191) $refs.search.focus()"
        class="bg-gray-800 rounded-full w-64 px-4 pl-8 py-1 focus:outline-none focus:ring focus:border-indigo-200"
        placeholder="Search (Press '/' to focus)">
    <div class="absolute top-0">
        <svg class="fill-current w-4 text-gray-500 mt-2 ml-2" viewBox="0 0 24 24">
            <path class="heroicon-ui"
                d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z" />
        </svg>
    </div>

    <div wire:loading class="absolute top-0 right-0">
        <div class="mt-2 mr-2 animate-spin rounded-full h-4 w-4 border-t-2 border-b-2  border-white">
        </div>
    </div>


    @if (strlen($search) > 2)
    <div class="z-10 absolute bg-gray-800 text-sm rounded w-64 mt-4" @keydown.escape.window="isOpen = false"
        x-show.transition.opacity="isOpen">
        @if ($searchResults->count() > 0)
        <ul>
            @foreach ($searchResults as $result)
            <li class="border-b border-gray-700">
                <a href="{{ route('movies.show', $result['id']) }}"
                    class="hover:bg-gray-700 px-3 py-3 flex items-center transition ease-in-out duration-150"
                    @if($loop->last) @keydown.tab="isOpen = false" @endif
                    >
                    @if ($result['poster_path'])
                    <img src="{{ 'https://image.tmdb.org/t/p/w92'.$result['poster_path'] }}" class="w-8" alt="poster">
                    @else
                    <img src="https://via.placeholder.com/75" class="w-8" alt="poster">

                    @endif

                    <span class="ml-4"> {{$result['title'] }}</span>
                </a>
            </li>
            @endforeach
        </ul>
        @else
        <div class="px-3 py-3">No results for "{{ $search }}"</div>
        @endif
    </div>
    @endif
</div>