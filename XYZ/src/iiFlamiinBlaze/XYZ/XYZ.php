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

namespace iiFlamiinBlaze\XYZ;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\GameRulesChangedPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class XYZ extends PluginBase{

    private const VERSION = "v1.0.1";
    private const PREFIX = TextFormat::AQUA . "XYZ" . TextFormat::GOLD . " > ";

    /** @var array $xyz */
    private $xyz = [];

    public function onEnable() : void{
        $this->getLogger()->info("XYZ " . self::VERSION . " by BlazeTheDev is enabled");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if($command->getName() === "xyz"){
            if(!$sender instanceof Player){
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "Use this command in-game");
                return false;
            }
            if(!$sender->hasPermission("xyz.command")){
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "You do not have permission to use this command");
                return false;
            }
            if(!in_array($sender->getName(), $this->xyz)){
                $this->xyz[] = $sender->getName();
                $pk = new GameRulesChangedPacket();
                $pk->gameRules = ["showcoordinates" => [1, true]];
                $sender->dataPacket($pk);
                $sender->sendMessage(self::PREFIX . TextFormat::GREEN . "You have turned on your coords");
            }elseif(in_array($sender->getName(), $this->xyz)){
                unset($this->xyz[array_search($sender->getName(), $this->xyz)]);
                $pk = new GameRulesChangedPacket();
                $pk->gameRules = ["showcoordinates" => [1, false]];
                $sender->dataPacket($pk);
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "You have turned off your coords");
            }
        }
        return true;
    }
}