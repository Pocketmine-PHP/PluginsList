<?php
/**
 *  ____  _            _______ _          _____
 * |  _ \| |          |__   __| |        |  __ \
 * | |_) | | __ _ _______| |  | |__   ___| |  | | _____   __
 * |  _ <| |/ _` |_  / _ \ |  | '_ \ / _ \ |  | |/ _ \ \ / /
 * | |_) | | (_| |/ /  __/ |  | | | |  __/ |__| |  __/\ V /
 * |____/|_|\__,_/___\___|_|  |_| |_|\___|_____/ \___| \_/
 *
 * Copyright (C) 2018 iiFlamiinBlaze
 *
 * iiFlamiinBlaze's plugins are licensed under MIT license!
 * Made by iiFlamiinBlaze for the PocketMine-MP Community!
 *
 * @author iiFlamiinBlaze
 * Twitter: https://twitter.com/iiFlamiinBlaze
 * GitHub: https://github.com/iiFlamiinBlaze
 * Discord: https://discord.gg/znEsFsG
 */
declare(strict_types=1);

namespace iiFlamiinBlaze\Heal;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Heal extends PluginBase{

    private const VERSION = "v1.0.0";
    private const PREFIX = TextFormat::AQUA . "Heal" . TextFormat::GOLD . " > ";

    public function onEnable() : void{
        $this->getLogger()->info("Heal " . self::VERSION . " by BlazeTheDev is enabled");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if($command->getName() === "heal"){
            if(!$sender instanceof Player){
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "Use this command in-game");
                return false;
            }
            if(!$sender->hasPermission("heal.command")){
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "You do not have permission to use this command");
                return false;
            }
            if(empty($args[0])){
                $sender->setHealth(20);
                $sender->sendMessage(self::PREFIX . TextFormat::GREEN . "You have healed yourself");
                return false;
            }
            if($this->getServer()->getPlayer($args[0])){
                $player = $this->getServer()->getPlayer($args[0]);
                $player->setHealth(20);
                $player->sendMessage(self::PREFIX . TextFormat::GREEN . "You have been healed by " . $sender->getName());
                $sender->sendMessage(self::PREFIX . TextFormat::GREEN . "You have healed " . $player->getName());
            }else{
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "Player not found");
                return false;
            }
        }
        return true;
    }
}