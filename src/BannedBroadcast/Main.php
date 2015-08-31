<?php

# BannedBroadcast by @ItalianDevs4PM

namespace BannedBroadcast;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerPreLoginEvent;

class Main extends PluginBase{

  public function OnEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info(TextFormat::GREEN . "BannedBroadcast is enabled!");
    $this->saveDefaultConfig();
  }

  public function OnDisable(){
    $this->getLogger()->info(TextFormat::RED . "BannedBroadcast is disabled!");
  }

  public function onPreLogin(PlayerPreLoginEvent $e){
    $player = $e->getPlayer();
    $name = $e->getPlayer()->getName();
    $ip = $e->getPlayer()->getAddress();
    $bmessageconf = $this->getConfig()->get("banned-message");
    $wmessageconf = $this->getConfig()->get("unwhitelisted-message");
    $bmessage = str_replace(["{player}","{ip}"],[$name,$ip],$bmessageconf);
    $wmessage = str_replace(["{player}","{ip}"],[$name,$ip],$wmessageconf);
    if($player->isBanned()){
      foreach($this->getServer()->getOnlinePlayers as $ps){
        if($ps->hasPermission("bb.ban"){
          $ps->sendMessage(TextFormat::BLUE . "[BB] ".$bmessage);
          $this->getLogger()->info(TextFormat::BLUE . "[BB] ".$bmessage);
        }
      }
    }
    if(!$player->isWhitelisted()){
      foreach($this->getServer()->getOnlinePlayers as $ps){
        if($ps->hasPermission("bb.whitelist"){
          $ps->sendMessage(TextFormat::BLUE . "[BB] ".$wmessage);
          $this->getLogger()->info(TextFormat::BLUE . "[BB] ".$wmessage);
        }
      }
    }
  }
}
