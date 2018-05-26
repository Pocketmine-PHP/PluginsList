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

namespace iiFlamiinBlaze\NoVoid;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class NoVoid extends PluginBase implements Listener{

    private const VERSION = "v1.0.0";
    private const PREFIX = TextFormat::AQUA . "NoVoid" . TextFormat::GOLD . " > ";

    public function onEnable() : void{
        $this->getLogger()->info("NoVoid " . self::VERSION . " by BlazeTheDev is enabled");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDamage(EntityDamageEvent $event) : void{
        $entity = $event->getEntity();
        if($entity instanceof Player){
            if($entity->getPosition()->getY() < 0){
                $event->setCancelled(true);
                $entity->teleport($this->getServer()->getDefaultLevel()->getSafeSpawn());
                $entity->sendMessage(self::PREFIX . TextFormat::GREEN . "You were teleported out of the void");
            }
        }
    }
}