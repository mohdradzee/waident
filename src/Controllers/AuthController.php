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
        $ipAddress = '127.0.0.1';
        $platformId = \App\Enums\PlayerSourceEnum::from('direct')->value;
        try {
            $player = Player::where('wl_player_username',$request->username)->firstOrCreate([
                'wl_player_username' => $request->username
            ], [
                Player::PLAYER_PHONE_NUMBER => $request->username.'123',
                Player::PLAYER_PASSWORD => bcrypt('123123'),
                'last_login' => \Carbon\Carbon::now(config('app.timezone')),
                Player::PLAYER_GROUP_ID => null,
                'registered_from_platform' => $platformId,
                'last_login_from_platform' => \Carbon\Carbon::now(config('app.timezone')),
                Player::PLAYER_FULLNAME => $request->username,
                Player::PLAYER_REGISTER_IP => $ipAddress,
                Player::PLAYER_LAST_LOGIN_IP => $ipAddress,
            ]);

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
            return $player;
        }catch(\Exception $e){
            \Log::critical($e);
        }
    }

    public function demoInitAuth()
    {
        return view('waident::index',['merchantId'=>config('app.merchant_id')]);
    }
}