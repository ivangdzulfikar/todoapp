<div>
    @if (session('error'))
        <div id="alert-border-2" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50"
            role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div class="ml-3 text-sm font-medium">
                {{ session('error') }}
            </div>
        </div>
    @endif

    @include('livewire.includes.todo-create-box')
    @include('livewire.includes.search-box')

    <div id="todos-list">
        @if ($todos->count(0))
            @foreach ($todos as $todo)
                @include('livewire.includes.todo-card')
            @endforeach

            <div class="my-2">
                {{ $todos->links() }}
            </div>
        @else
            <div class="text-red-500 text-center border-t-2 border-blue-500">
                <h1 class="my-4">Not found.</h1>
            </div>
        @endif
    </div>

</div>
