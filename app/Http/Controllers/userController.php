<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class userController extends Controller
{
    //
    public function register(Request $request) {
        $incomingData = $request->validate([
            'username'=> ['required', Rule::unique('users','username') ], 
            'email'=> ['required','email', Rule::unique('users','email') ],
            'password'=> ['required','min:8','confirmed']
        ]);

        $incomingData['password'] =bcrypt($incomingData['password']);

        $user = User::create($incomingData);
        auth()->login($user);
        return redirect('/')->with('success','Thank you for creating an account');
    }

    public function login(Request $request) {
        $incomingData = $request->validate( [
            'loginusername'=>'required', 
            'loginpassword'=> 'required'
        ] );
        
        if(auth()->attempt(['username'=>$incomingData['loginusername'], 'password'=>$incomingData['loginpassword'] ])) {
            $request -> session()-> regenerate();
            return redirect('/')->with('success','Log in successful.');
        } else {
            return redirect('/')->with('failure', 'Login Invalid.');
        }
    }

    public function showCorrectHomepage(Request $request){        
        if(auth()->check()) { #checks whether you're logged in or not
            return view('homefeed', ['reviews'=> auth()->user()->feedPosts()->latest()->paginate(8)]);
        } else {
            return view('homepage');
        }
    }

    public function logout(Request $request){
        auth()->logout();
        return  redirect('/')->with('success', 'You are now logged out.');
    }

    private function getSharedData($user){   //Shared Function
        $currentlyFollowing = 0;

        if(auth()->check()){
            $currentlyFollowing = Follow::where([['user_id', '=' , auth()->user()->id],['followedUser', '=' , $user->id]])->count();
        }

        View::share('sharedData',['username' => $user->username, 'postCount'=>$user->posts()->count(), 'avatar' => $user->avatar, 'currentlyFollowing' => $currentlyFollowing, 'followerCount'=>$user->followers()->count(), 'followingCount'=>$user->followingTheseUsers()->count() ]);
    }

    public function profile(User $user){
        $this->getSharedData($user);
        return view('profile-posts',['posts'=>$user->posts()->latest()->get()]);
    }

    public function profileFollowers(User $user){
        $this->getSharedData($user);
        return view('profile-followers',['followers'=>$user->followers()->latest()->get()]);
    }

    public function profileFollowing(User $user){
        $this->getSharedData($user);
        return view('profile-following',['following'=>$user->followingTheseUsers()->latest()->get()]);
    }

    public function showAvatarForm() {
        return view('avatar-form');
    }
    public function storeAvatar(Request $request) { //You need to change the path of the storage shortcut in the top level public folder for it to work.  run 'php artisan storage:link' to do so
        $request->validate([
            'avatar'=>'required|image|max:2000'
        ]);

        $user = auth()->user();
        $filename = $user->id.'-'.uniqid().'.jpg';

        $imgData = Image::make($request->file('avatar'))->fit(120)->encode('jpg');        
        Storage::put('public/avatars/'.$filename,$imgData);
        
        $oldAvatar = $user->avatar;

        $user->avatar = $filename;
        $user->save();
        if($oldAvatar!=='fallback-avatar.jpg'){
            Storage::delete(str_replace('/storage/', 'public/', $oldAvatar));
        }
        return back()->with('success','Profile Avatar Updated');
    }

    public function search($term){
        $users = User::search($term)->get(); //Slight problem here
        return $users;
    }

}
