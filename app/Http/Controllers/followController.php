<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class followController extends Controller
{
    public function createFollow(User $user){
        //Can't folow Yourself:
        if($user->id==auth()->user()->id){
            return back()->with('failure','You cannot Follow Yourself.');
        }
        //You cannot follow someone you already follow
        $existCheck = Follow::where([['user_id','=',auth()->user()->id],['followeduser','=',$user->id]])->count();
        if($existCheck){
            return back()->with('failure','You are already Following this User');
        }
        
        //New Follower reg 
        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id; 
        $newFollow->followeduser = $user->id;
        $newFollow->save();
        return back()->with('success', 'You are now Following this User');
    }
    public function removeFollow(User $user){
        Follow::where([['user_id', '=', auth()->user()->id], ['followedUser', '=', $user->id]])->delete();
        return back()->with('success','You are no longer following this user');
    }
}
