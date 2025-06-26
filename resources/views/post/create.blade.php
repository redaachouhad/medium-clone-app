<x-app-layout>
    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 pb-10">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <h1 class="text-2xl font-bold">Create New Post</h1>
                <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">

                    @csrf

                    {{-- Upload Image --}}

                    <div class="mt-4">
                        <x-input-label for="image" :value="__('Image')" />
                        <x-text-input id="image" class="block mt-1 w-full border" type="file" name="image"
                            :value="old('image')" />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or
                            GIF
                            (MAX. 800x400px).</p>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>


                    {{-- Title --}}
                    <div class="mt-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title')" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>




                    {{-- Category --}}
                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select name="category_id" id="category_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Choose a category</option>
                            @foreach ($categories as $category)
                                <option value={{ $category->id }} @selected(old('category_id') == $category->id)>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>


                    {{-- Content --}}
                    <div class="mt-4">
                        <x-input-label for="content" :value="__('Content')" />
                        <x-text-inputarea id="content" class="block mt-1 w-full" name="content"
                            :value="old('content')">{{ old('content') }}</x-text-inputarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button>Submit</x-primary-button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</x-app-layout>
