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

namespace iiFlamiinBlaze\WorldTP;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class WorldTP extends PluginBase{

    private const VERSION = "v1.0.0";
    private const PREFIX = TextFormat::AQUA . "WorldTP" . TextFormat::GOLD . " > ";

    public function onEnable() : void{
        $this->getLogger()->info("WorldTP " . self::VERSION . " by BlazeTheDev is enabled");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if($command->getName() === "worldtp"){
            if(!$sender instanceof Player){
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "Use this command in-game");
                return false;
            }
            if(!$sender->hasPermission("worldtp.command")){
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "You do not have permission to use this command");
                return false;
            }
            if(empty($args[0])){
                $sender->sendMessage(self::PREFIX . TextFormat::GRAY . "Usage: /worldtp <world>");
                return false;
            }
            if(file_exists($this->getServer()->getDataPath() . "worlds/" . $args[0])){
                $sender->teleport($this->getServer()->getLevelByName($args[0])->getSafeSpawn());
                $sender->sendMessage(self::PREFIX . TextFormat::GREEN . "You have been teleported to the world named $args[0]");
            }else{
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "World does not exist");
                return false;
            }
        }
        return true;
    }
}