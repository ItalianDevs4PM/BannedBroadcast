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

    $bmessage = str_replace(["{player}","{ip}"] ,[$player->getName(), $player->getAddress()], $this->getConfig()->get("banned-message"));
    $wmessage = str_replace(["{player}","{ip}"], [$player->getName(), $player->getAddress()], $this->getConfig()->get("unwhitelisted-message"));

    if($player->isBanned()){
      foreach($this->getServer()->getOnlinePlayers() as $ps){
        if($ps->hasPermission("bb.ban")){
          $ps->sendMessage(TextFormat::BLUE . "[BB] ".$bmessage);
        }
      }
    }
    if(!$player->isWhitelisted()){
      foreach($this->getServer()->getOnlinePlayers() as $ps){
        if($ps->hasPermission("bb.whitelist")){
          $ps->sendMessage(TextFormat::BLUE . "[BB] ".$wmessage);
        }
      }
    }
  }
}
