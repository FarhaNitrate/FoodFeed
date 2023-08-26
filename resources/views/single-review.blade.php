<x-layout :doctitle="$review->restaurantName">
    <div class="container py-md-5 container--narrow">
      <div class="d-flex justify-content-between">
        <h1>{{$review->restaurantName}}</h1>
        @can('update', $review)
        <span class="pt-2">
          <a href="/review/{{$review->id}}/edit" class="text-primary mr-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
          <form class="delete-post-form d-inline" action="/review/{{$review->id}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
          </form>
        </span>
        @endcan
      </div>

      <p class="text-muted small mb-4">
        <a href="/profile/{{$review->user->username}}"><img class="avatar-tiny" src="{{$review->user->avatar}}" /></a>
        Posted by <a href="/profile/{{$review->user->username}}">{{$review->user->username}}</a> on {{$review->created_at->format('j/n/Y')}}
      </p>

      <div class="body-content">
        <h4>Location: {{$review->location}} </h4>        
      </div>

      <div class="body-content">
        {!! $review->detailedReview !!}       
      </div>
    </div>

    <!-- Display the image -->
    @if ($review->image)
    <div class="my-4">
      <img src= "{{ Storage::url('public/images/' . $review->image) }}" alt="Review Image" style="display: block; margin: 0 auto;">

    </div>
    @endif
    </div>

</html>
</x-layout>