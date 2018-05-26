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

namespace iiFlamiinBlaze\KillMoney;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class KillMoney extends PluginBase implements Listener{

    private const VERSION = "v1.0.0";

    public function onEnable() : void{
        $this->economyCheck();
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("KillMoney " . self::VERSION . " by BlazeTheDev is enabled");
    }

    private function economyCheck() : bool{
        if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") === null or $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->isDisabled()){
            $this->getPluginLoader()->disablePlugin($this);
            $this->getLogger()->error("Plugin Disabled! You must enable/install EconomyAPI for this plugin to work");
            return false;
        }
        return true;
    }

    public function onPlayerDeath(PlayerDeathEvent $event) : void{
        $victim = $event->getPlayer();
        if($victim->getLastDamageCause() instanceof EntityDamageByEntityEvent){
            if($victim->getLastDamageCause()->getEntity() instanceof Player){
                $killer = $victim->getLastDamageCause()->getEntity();
                if(!$killer instanceof Player) return;
                $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->getInstance()->addMoney($killer, (float)$this->getConfig()->get("money"));
                $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->getInstance()->reduceMoney($victim, (float)$this->getConfig()->get("money"));
                $killer->sendMessage(str_replace(["{money}", "{player}"], [$this->getConfig()->get("money"), $victim->getName()], $this->getConfig()->get("message")));
            }
        }
    }
}
