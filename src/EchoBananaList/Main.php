<?php

namespace EchoBananaList\Main;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerPreLoginEvent;

class Main extends PluginBase{

public function OnEnable(){
$this->getServer()->getPluginManager()->registerEvents($this, $this);
$this->getLogger()->info(TextFormat::GREEN . "[EBL] Enabled");
}

public function OnDisable(){
$this->getLogger()->info(TextFormat::RED . "[EBL] Disabled");
}

public function onPreLogin(PlayerPreLoginEvent $e){
$player = $e->getPlayer();
$name = $e->getPlayer()->getName();
if($player->isBanned){
foreach($this->getServer()->getOnlinePlayers as $ps){
if($ps->hasPermission("ebl.ban"){
$ps->sendMessage(TextFormat::BLUE . "[EBL]" $name." Ha tentato di entrare nel server anche se bannato");
    }
   }
  }
if($player->isWhitelisted()){
foreach($this->getServer()->getOnlinePlayers as $ps){
if($ps->hasPermission("ebl.whitelist"){
$ps->sendMessage(TextFormat::BLUE . "[EBL]" $name." Ha tentato di entrare nel server anche se in whitelist");
    }
   }
  }
 }
}
