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

namespace iiFlamiinBlaze\DoubleJump;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJumpEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\plugin\PluginBase;

class DoubleJump extends PluginBase implements Listener{

    private const VERSION = "v1.0.1";

    /** @var array $jumps */
    public $jumps = [];
    /** @var self $instance */
    private static $instance;

    public function onEnable() : void{
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("DoubleJump " . self::VERSION . " by BlazeTheDev is enabled");
    }

    public function onPreLogin(PlayerPreLoginEvent $event) : void{
        $player = $event->getPlayer();
        $this->jumps[$player->getName()] = 0;
    }

    public function onJump(PlayerJumpEvent $event) : void{
        $player = $event->getPlayer();
        $this->jumps[$player->getName()]++;
        if($this->jumps[$player->getName()] === 1){
            $this->getServer()->getScheduler()->scheduleDelayedTask(new DoubleJumpTask($this, $player), 30);
        }
        if($this->jumps[$player->getName()] === 2){
            $player->knockBack($player, 0, $player->getDirectionVector()->getX(), $player->getDirectionVector()->getZ(), 1);
            $this->jumps[$player->getName()] = 0;
        }
    }

    public static function getInstance() : self{
        return self::$instance;
    }
}