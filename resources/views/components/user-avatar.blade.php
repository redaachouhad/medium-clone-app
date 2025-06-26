@props(['user', 'size' => 'w-12 h-12'])


@if ($user->image)
    <img src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}" class="{{ $size }} rounded-full">
@else
    <img src="https://i.pinimg.com/736x/7b/8c/d8/7b8cd8b068e4b9f80b4bcf0928d7d499.jpg" alt="Dummy avatar"
        class="{{ $size }} rounded-full">
@endif
