<?php
namespace Mohdradzee\Waident\Controllers;

use App\Components\Modules\Player\Player;
use Auth;
use Illuminate\Http\Request;
use Mohdradzee\Waident\Requests\PasskeyAuthInitRequest;
use Util;
class AuthController
{
    /**
     * checkPlayerUsername
     * Prior to initiate passkey authentication/registration 
     * we check whether the player username exists
     * @param  Request  $request
     */
    public function checkPlayerUsername(PasskeyAuthInitRequest $request)
    {
        if ($request->ajax()) {
            try{
                $player = config('waident.playerModel')::where('wl_player_username',$request->username)->firstOrFail();
                return response()->json($this->createPayload($request->all()),200);//will attempt authentication
            }catch(\Exception $e){
                return response()->json($this->createPayload($request->all()),400);//will attempt to create new player
            }
        }
        return response()->json(['Bad request'], 500);
    }

    private function createChallenge($arr):array
    {
        $hash = \crypt(\serialize($arr), config('app.merchant_api_salt_key'));
        return ['hash'=>$hash];
    }

    private function createPayload($arr):array
    {
        $mergingArr = array_merge($arr,['merchantId'=>config('app.merchant_id')],$this->createChallenge($arr));
        $payload = \base64_encode(\serialize($mergingArr));
        $test = \base64_decode($payload);
        $backToArray = \Log::info(\unserialize($test));
        return ['payload'=>$payload];
    }

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