<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    //
    public function createFollow(User $user) {
        // nao pode seguir voce mesmo
        if ($user->id == auth()->user()->id) {
            return back()->with('failure', 'Não pode seguir voce mesmo');
        }

        // nao pode seguir quem ja esta seguindo
        $existCheck = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();

        if ($existCheck) {
            return back()->with('failure', 'Voce ja segue este usuario');
        }

        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        return back()->with('success', 'Usuario seguido com sucesso');
        
    }

    public function removeFollow(User $user) {
        Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->delete();

        return back()->with('success', 'Voce deixou de seguir este usuario');
    }
}
