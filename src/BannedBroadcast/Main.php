<?php

# BannedBroadcast by @ItalianDevs4PM

/*
Copyright (C) 2015 ItalianDevs4PM

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
*/

namespace BannedBroadcast;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerPreLoginEvent;

class Main extends PluginBase implements Listener{

  public function onEnable(){
    if(!($this->getConfig()->get("banned-switch") == "on" or $this->getConfig()->get("banned-switch") == "off")){
      $this->getLogger()->alert(TextFormat::RED . "Unrecognized parameter '".$this->getConfig()->get("banned-switch")."' on banned switch");
      $this->getServer()->getPluginManager()->disablePlugin($this);
    }elseif(!($this->getConfig()->get("unwhitelisted-switch") == "on" or $this->getConfig()->get("unwhitelisted-switch") == "off")){
      $this->getLogger()->alert(TextFormat::RED . "Unrecognized parameter '".$this->getConfig()->get("unwhitelisted-switch")."' on unwhitelisted switch");
      $this->getServer()->getPluginManager()->disablePlugin($this);
    }else{
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      $this->getLogger()->info(TextFormat::GREEN . "BannedBroadcast is enabled!");
      $this->saveDefaultConfig();
    }
  }

  public function onDisable(){
    $this->getLogger()->info(TextFormat::RED . "BannedBroadcast is disabled!");
  }

  public function onPreLogin(PlayerPreLoginEvent $e){
    $player = $e->getPlayer();
    $bmessage = str_replace(["{player}","{ip}"] ,[$player->getName(), $player->getAddress()], $this->getConfig()->get("banned-message"));
    $wmessage = str_replace(["{player}","{ip}"], [$player->getName(), $player->getAddress()], $this->getConfig()->get("unwhitelisted-message"));
    
    if($this->getConfig()->get("banned-switch") !== "on") return;
    if($player->isBanned()){
      foreach($this->getServer()->getOnlinePlayers() as $ps){
        if($ps->hasPermission("bb.ban")){
          $ps->sendMessage(TextFormat::BLUE . "[BB] ".$bmessage);
        }
      }
    }
    if($this->getConfig()->get("unwhitelisted-switch") !== "on") return;
    if(!$player->isWhitelisted()){
      foreach($this->getServer()->getOnlinePlayers() as $ps){
        if($ps->hasPermission("bb.whitelist")){
          $ps->sendMessage(TextFormat::BLUE . "[BB] ".$wmessage);
        }
      }
    }
  }
}
