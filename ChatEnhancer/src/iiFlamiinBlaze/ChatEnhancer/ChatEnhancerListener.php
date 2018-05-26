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

namespace iiFlamiinBlaze\ChatEnhancer;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\TextFormat;

class ChatEnhancerListener implements Listener{

    public function onChat(PlayerChatEvent $event) : void{
        $player = $event->getPlayer();
        if(ChatEnhancer::getInstance()->getConfig()->get("chat-listener") === "on"){
            if(ChatEnhancer::getInstance()->getConfig()->get("op-bypass") === "on" && $player->isOp()) return;
            foreach(ChatEnhancer::getInstance()->getConfig()->get("blocked-words") as $words){
                if(stripos($event->getMessage(), $words) !== false){
                    $player->sendMessage(TextFormat::RED . "No swearing!");
                    $event->setCancelled(true);
                }
            }
            foreach(ChatEnhancer::getInstance()->getConfig()->get("blocked-links") as $links){
                if(stripos($event->getMessage(), $links) !== false){
                    $player->sendMessage(TextFormat::RED . "No advertising!");
                    $event->setCancelled(true);
                }
            }
        }
    }
}