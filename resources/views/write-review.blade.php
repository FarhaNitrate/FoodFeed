<x-layout doctitle="Create New Post">
    <div class="container py-md-5 container--narrow">
        <form action="/write-review" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="post-title" class="text-muted mb-1"><small>Restaurant Name</small></label>
            <input value='{{old('restaurantName')}}' name="restaurantName" id="post-title" class="form-control form-control-lg form-control-title" type="text" placeholder="" autocomplete="off" />
            @error('restaurantName')
            <p class='m-0 small alert alert-danger shadow-sm'>{{$message}}</p>
            @enderror
          </div>          
  
          <div class="form-group">
            <label for="post-location" class="text-muted mb-1"><small>Location</small></label>
            <input value='{{old('location')}}' name="location" id="post-location" class="body-content tall-textarea form-control" type="text" placeholder="" autocomplete="off" />
            @error('location')
            <p class='m-0 small alert alert-danger shadow-sm'>{{$message}}</p>
            @enderror
          </div>

          <div class="form-group">
            <label for="post-body" class="text-muted mb-1"><small>Detailed Review</small></label>
            <textarea name="detailedReview" id="post-body" class="body-content tall-textarea form-control" type="text">{{old('detailedReview')}}</textarea>
            @error('detailedReview')
            <p class='m-0 small alert alert-danger shadow-sm'>{{$message}}</p>
            @enderror
          </div> 

          <div class="form-group">
            <label for="post-image" class="text-muted mb-1"><small>Upload Image</small></label>
            <input type="file" name='image'>
            @error('image')
            <p class='m-0 small alert alert-danger shadow-sm'>{{$message}}</p>
            @enderror
        </div>         
          <button type="submit" class="btn btn-primary">Post Review</button>
        </form>
    </div>
</x-layout>