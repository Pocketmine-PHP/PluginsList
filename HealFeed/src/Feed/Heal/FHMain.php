<?php

namespace Feed\Heal;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

class FHMain extends PluginBase implements Listener {

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args){
        if($sender->hasPermission('server.heal')) {
            if ($cmd->getName() == "heal") {
                $sender->setHealth(20);
            }
        }
        if($sender->hasPermission('server.feed')) {
            if ($cmd->getName() == "feed") {
                $sender->setFood(20);
            }
        }
    }
}
