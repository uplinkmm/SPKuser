<?php
namespace App\Http\Action;

use App\Models\GameSetting;

class GameData{
    use GameClosing;
    private $game_id;
    public function __construct($game_id)
    {
        $this->game_id=$game_id;
    }
    public function getGame($gameSettingId){
        $game=$this->game_id==1 ? $this->get2dGame($gameSettingId) : $this->get3dGame($gameSettingId);
        // $gameArray = $game->toArray();
        // Combine and rename the settings
        $settings = [];

        // if (isset($gameArray['game_settings'])) {
        //     $settings = array_merge($settings, $gameArray['game_settings']);
        //     unset($gameArray['game_settings']);  
        // }

       
        return $game;
    }

    public function get2dGame($gameSettingId){
        $gameSetting=GameSetting::with('game')->where('is_active',1)
        ->find($gameSettingId);
        $gameSetting->type=$gameSetting->game->type;
        return $gameSetting;
        // $game= \App\Models\Game::orderBy('id','asc')
        // ->where('id',$this->game_id)
        // // ->withTimeStatus($timeStatus)
        // ->first();
        // return $game;
    }

    public function get3dGame($timeStatus){
        $game= \App\Models\Game::orderBy('id','asc')
        ->where('id',$this->game_id)
        ->withThreedSetting($this->game_id)
        ->first();
        $setting = null;
        // If the game has a three_d_setting, assign it to the settings variable and remove it from the game object
        if ($game->threedSetting ) {
            $setting = $game->threedSetting;
            unset($game['threed_setting']);
            unset($game['threedSetting']);
        }
        // Combine and rename the settings in the game object
        $game->game_setting = $setting;
        $game->three_d_setting=null;
        // Return the modified game object
        return $game;
    }
}