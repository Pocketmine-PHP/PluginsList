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

namespace iiFlamiinBlaze\BlazinFeed;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\Player;

class BlazinFeed extends PluginBase{

    private const VERSION = "v1.2.1";
    private const PREFIX = TextFormat::AQUA . "BlazinFeed" . TextFormat::GOLD . " > ";

    public function onEnable() : void{
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getLogger()->info("BlazinFeed " . self::VERSION . " by BlazeTheDev is enabled");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if($command->getName() === "feed"){
            if(!$sender instanceof Player){
                $sender->sendMessage(TextFormat::RED . "Use this command in-game");
                return false;
            }
            if(!$sender->hasPermission("feed.command")){
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "You do not have permission to use this command");
                return false;
            }
            if(empty($args[0])){
                $sender->setFood(20);
                $sender->setSaturation(20);
                $sender->sendMessage($this->getConfig()->get("fed-message"));
                return false;
            }
            if($this->getServer()->getPlayer($args[0])){
                $player = $this->getServer()->getPlayer($args[0]);
                $player->setFood(20);
                $player->setSaturation(20);
                $player->sendMessage($this->getConfig()->get("fed-message"));
                $sender->sendMessage(self::PREFIX . TextFormat::GREEN . "You have fed " . $player->getName());
            }else{
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "Player not found");
                return false;
            }
        }
        return true;
    }
}