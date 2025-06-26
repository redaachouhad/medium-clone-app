<x-app-layout>


    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 pb-10">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-category-tabs name="Reda">
                        No Categories
                    </x-category-tabs>
                </div>
            </div>
            <div class="overflow-hidden sm:rounded-lg mt-8">
                <div class="p-0 text-gray-900">
                    @forelse ($posts as $post)
                        <x-post-item :post="$post" />
                    @empty
                        <div>
                            <p class="text-gray-900  text-center py-16">No Posts found.</p>
                        </div>
                    @endforelse


                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
