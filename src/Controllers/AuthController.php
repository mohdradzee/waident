<?php
namespace Mohdradzee\Waident\Controllers;

use App\Components\Modules\Player\Player;
use App\Models\PlayerModel;
use Auth;
use Cookie;
use Illuminate\Http\Request;
use Util;

class AuthController
{
    /**
     * this is the callback
     */
    public function authenticate(Request $request)
    {
        $player = Player::where('wl_player_username',$request->username)->firstOrFail();
    
        if (Auth::loginUsingId($player->wl_player_id)) {

            if ($response = Player::updateLastLoginInfo($player, $request)) {
               Player::removeAuthSessionId($response['old_auth_session_id']);
            }
            $displayNav = ! Util::isMobile() ? false : true;
            return redirect('/');
        }else{
            dd('failed logn');
        }
        // Player::updateLastLoginInfo($player, $request);
        // Cookie::queue('firstAuthChkForPopup', 1, 1 * 60 * 24);
        // return redirect('/');
        // //dd($player);
    }

    public function demoInitAuth()
    {
        return view('waident::index');
    }
}