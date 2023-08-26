<x-layout>
    <div class="container py-md-5 container--narrow">
      @unless($reviews->isEmpty())
      <h2 class="text-center mb-4">The Latest From Those You Follow</h2>
      <div class="list-group">
        @foreach($reviews as $review)
        <a href="/review/{{$review->id}}" class="list-group-item list-group-item-action">
            <img class="avatar-tiny" src="{{$review->user->avatar}}" />
            <strong>{{$review->restaurantName}}</strong> <span class="text-muted small"> by {{$review->user->username}} on {{$review->created_at->format('j/n/Y')}}</span>
          </a>
        @endforeach
    </div>
    
    <div class="mt-4">
    {{$reviews->links()}}
    </div>

      @else
      <div class="text-center">
        <h2>Hello <strong>{{auth()->user()->username}}</strong>! This is your feed.</h2>
        <p class="lead text-muted">There's nothing to show here as of yet, but typically, your feed will display a list of Restaurants that are popular right now based on people you follow. Start following people so that you can read their reviews about individual food items on your very own Feed. You can also use the &ldquo;Search&rdquo; feature in the top menu bar to find the Restaurants/Users you're looking for.</p>
      </div>
      @endunless

      </div>
</x-layout>