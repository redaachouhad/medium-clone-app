@props(['user'])

<div x-data="{
    following: {{ auth()->user() && $user->isFollowedBy(auth()->user()) ? 'true' : 'false' }},
    followersCount: {{ $user->followers()->count() }},
    isLogged: {{ auth()->check() ? 'true' : 'false' }},
    follow() {

        if (!this.isLogged) {
            if (confirm('Please login to follow. Do you want to go to the login page?')) {
                // Redirect to login page
                window.location.href = '/login';
            }
            return;
        }

        this.following = !this.following;
        axios.post('/follow/{{ $user->id }}')
            .then(
                res => {
                    this.followersCount = res.data.followers;
                }
            ).catch(err => {
                console.log(err)
            })
    },
}" attributes='{{ $attributes->merge(['class' => '']) }}'>
    {{ $slot }}
</div>
