<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Profile">
  <div class="list-group">
    @foreach($posts as $post)
    <a href="/review/{{$post->id}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="{{$post->user->avatar}}" />
        <strong>{{$post->restaurantName}}</strong> on {{$post->created_at->format('j/n/Y')}}
      </a>
    @endforeach
</div>
</x-profile>