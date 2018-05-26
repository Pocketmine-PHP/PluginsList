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

namespace iiFlamiinBlaze\Freeze;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Freeze extends PluginBase implements Listener{

    private const VERSION = "v1.0.0";
    private const PREFIX = TextFormat::AQUA . "Freeze" . TextFormat::GOLD . " > ";

    /** @var array $freeze */
    private $freeze = [];

    public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("Freeze " . self::VERSION . " by BlazeTheDev is enabled");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if($command->getName() === "freeze"){
            if(!$sender instanceof Player){
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "Use this command in-game");
                return false;
            }
            if(!$sender->hasPermission("freeze.command")){
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "You do not have permission to use this command");
                return false;
            }
            if(empty($args[0])){
                $sender->sendMessage(self::PREFIX . TextFormat::GRAY . "Usage: /freeze <player>");
                return false;
            }
            if($this->getServer()->getPlayer($args[0])){
                $player = $this->getServer()->getPlayer($args[0]);
                if(!in_array($player->getName(), $this->freeze)){
                    $this->freeze[] = $player->getName();
                    $player->sendMessage(self::PREFIX . TextFormat::GREEN . "You have been frozen");
                    $sender->sendMessage(self::PREFIX . TextFormat::GREEN . "You have frozen " . $player->getName());
                }elseif(in_array($player->getName(), $this->freeze)){
                    unset($this->freeze[array_search($player->getName(), $this->freeze)]);
                    $player->sendMessage(self::PREFIX . TextFormat::GREEN . "You have been unfrozen");
                    $sender->sendMessage(self::PREFIX . TextFormat::GREEN . "You have unfrozen " . $player->getName());
                }
            }else{
                $sender->sendMessage(self::PREFIX . TextFormat::RED . "Player not found");
                return false;
            }
        }
        return true;
    }

    public function onMove(PlayerMoveEvent $event) : void{
        if(in_array($event->getPlayer()->getName(), $this->freeze)) $event->setCancelled(true);
    }
}