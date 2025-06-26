<ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400 items-center justify-center">
    <li class="me-2">
        <a href="{{ route('dashboard') }}"
            class="{{ Route::currentRouteNamed('dashboard') ? 'inline-block px-4 py-2 text-white bg-blue-600 rounded-lg active' : 'inline-block px-4 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white' }}"
            aria-current="page">All</a>
    </li>

    @forelse ($categories as $category)
        <li class="me-2">
            <a href="{{ route('post.byCategory', ['category' => $category->name]) }}"
                class="{{ request('category') && request('category')->id == $category->id && Route::currentRouteNamed('post.byCategory') ? 'inline-block px-4 py-2 text-white bg-blue-600 rounded-lg active' : 'inline-block px-4 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-500 dark:hover:text-white' }}">
                {{ $category->name }}
            </a>
        </li>
    @empty
        {{ $slot }}
    @endforelse
</ul>
