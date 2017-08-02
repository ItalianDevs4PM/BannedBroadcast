<?php

// BannedBroadcast by @ItalianDevs4PM

/*
Copyright (C) 2015-2017 ItalianDevs4PM

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
*/

namespace BannedBroadcast;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerPreLoginEvent;

class Main extends PluginBase implements Listener{

  public function onEnable(){
    $this->saveDefaultConfig();
    if($this->getConfig()->get("banned-switch") !== true && $this->getConfig()->get("banned-switch") !== false){
      $this->getLogger()->alert(TextFormat::RED . "Unrecognized parameter ".$this->getConfig()->get("banned-switch")." on banned-switch");
      $this->getServer()->getPluginManager()->disablePlugin($this);
      return;
    }
    if($this->getConfig()->get("unwhitelisted-switch") !== true && $this->getConfig()->get("unwhitelisted-switch") !== false){
      $this->getLogger()->alert(TextFormat::RED . "Unrecognized parameter ".$this->getConfig()->get("unwhitelisted-switch")." on unwhitelisted-switch");
      $this->getServer()->getPluginManager()->disablePlugin($this);
      return;
    }
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      $this->getLogger()->info(TextFormat::GREEN . "BannedBroadcast is enabled!");
    }
  }

  public function onDisable(){
    $this->getLogger()->info(TextFormat::RED . "BannedBroadcast is disabled!");
  }

  public function onPreLogin(PlayerPreLoginEvent $e){
    if($this->getConfig()->get("banned-switch") === true && $e->getPlayer()->isBanned()){
      foreach($this->getServer()->getOnlinePlayers() as $ps){
        if($ps->hasPermission("bb.ban")){
          $ps->sendMessage(TextFormat::YELLOW . "[BB] " . str_replace(["{player}", "{ip}"], [$player->getName(), $player->getAddress()], $this->getConfig()->get("banned-message")));
        }
      }
    }
    
    if($this->getConfig()->get("unwhitelisted-switch") === true && !$e->getPlayer()->isWhitelisted()){
      foreach($this->getServer()->getOnlinePlayers() as $ps){
        if($ps->hasPermission("bb.whitelist")){
          $ps->sendMessage(TextFormat::YELLOW . "[BB] " . str_replace(["{player}", "{ip}"], [$player->getName(), $player->getAddress()], $this->getConfig()->get("unwhitelisted-message")));
        }
      }  
    }
  }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        switch($command->getName()){
            case "unwl":
                if(isset($args[0])){
                    if(strtolower($args[0]) === "on") {
                        $this->getConfig()->set("unwhitelisted-switch", true);
                        $sender->sendMessage(TextFormat::GREEN . "[BB] Unwhitelisted alerts enabled");
                    }elseif(strtolower($args[0]) === "off"){
                        $this->getConfig()->set("unwhitelisted-switch", false);
                        $sender->sendMessage(TextFormat::RED . "[BB] Unwhitelisted alerts disabled");
                    }else{
                      return false;
                    }
                    return true;
                }else{
                  return false;
                }
                break;
            case "bb":
                if(isset($args[0])){
                    if(strtolower($args[0]) === "on"){
                        $this->getConfig()->set("banned-switch", true);
                        $sender->sendMessage(TextFormat::GREEN . "[BB] Banned alerts enabled!");
                    }elseif(strtolower($args[0]) === "off"){
                        $this->getConfig()->set("banned-switch", false);
                        $sender->sendMessage(TextFormat::RED . "[BB] Banned alerts disabled!");
                    }else{
                      return false;
                    }
                    return true;
                }else{
                  return false;
                }
                break;
            default:
                return false;
                break;
        }
    }
  
}
