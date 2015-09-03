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

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerPreLoginEvent;

class Main extends PluginBase implements Listener{

  public function onEnable(){
    $this->saveDefaultConfig();
    if($this->getConfig()->get("banned-switch") !== "on" and $this->getConfig()->get("banned-switch") !== "off"){
      $this->getLogger()->alert(TextFormat::RED . "Unrecognized parameter ".$this->getConfig()->get("banned-switch")." on banned switch");
      $this->getServer()->getPluginManager()->disablePlugin($this);
    }elseif($this->getConfig()->get("unwhitelisted-switch") !== "on" and $this->getConfig()->get("unwhitelisted-switch") !== "off"){
      $this->getLogger()->alert(TextFormat::RED . "Unrecognized parameter ".$this->getConfig()->get("unwhitelisted-switch")." on unwhitelisted switch");
      $this->getServer()->getPluginManager()->disablePlugin($this);
    }else{
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      $this->getLogger()->info(TextFormat::GREEN . "BannedBroadcast is enabled!");
    }
  }

  public function onDisable(){
    $this->getLogger()->info(TextFormat::RED . "BannedBroadcast is disabled!");
  }

  public function onPreLogin(PlayerPreLoginEvent $e){
    $player = $e->getPlayer();
    $bmessage = str_replace(["{player}", "{ip}"], [$player->getName(), $player->getAddress()], $this->getConfig()->get("banned-message"));
    $wmessage = str_replace(["{player}", "{ip}"], [$player->getName(), $player->getAddress()], $this->getConfig()->get("unwhitelisted-message"));
    
    if($this->getConfig()->get("banned-switch") === "on"){
      if($player->isBanned()){
        foreach($this->getServer()->getOnlinePlayers() as $ps){
          if($ps->hasPermission("bb.ban")){
            $ps->sendMessage(TextFormat::BLUE . "[BB] ".$bmessage);
          }
        }  
      }
    }
    
    if($this->getConfig()->get("unwhitelisted-switch") === "on"){
      if(!$player->isWhitelisted()){
        foreach($this->getServer()->getOnlinePlayers() as $ps){
          if($ps->hasPermission("bb.whitelist")){
            $ps->sendMessage(TextFormat::BLUE . "[BB] ".$wmessage);
          }
        }  
      }
    }
  }

    public function onCommand(CommandSender $sender, Command $command, $label, array $args){
        switch($command->getName()){
            case "unwl-switch":
                if(isset($args[0])){
                    if(strtolower($args[0]) === "on") {
                        $this->getConfig()->set("unwhitelisted-switch", "on");
                        $sender->sendMessage("Unwhitelisted alerts enabled");
                    }elseif(strtolower($args[0]) === "off"){
                        $this->getConfig()->set("unwhitelisted-switch", "off");
                        $sender->sendMessage("Unwhitelisted alerts disabled");
                    }else{
                      return false;
                    }
                    return true;
                }else{
                  return false;
                }
                break;
            case "unban-switch":
                if(isset($args[0])){
                    if(strtolower($args[0]) === "on"){
                        $this->getConfig()->set("banned-switch", "on");
                        $sender->sendMessage("Banned alerts enabled");
                    }elseif(strtolower($args[0]) === "off"){
                        $this->getConfig()->set("banned-switch", "off");
                        $sender->sendMessage("Banned alerts disabled");
                    }else{
                      return false;
                    }
                    return true;
                }else{
                  return false;
                }
            default:
                return false;
        }
    }
  
}
