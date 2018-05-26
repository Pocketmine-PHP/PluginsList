<?php

declare(strict_types=1);

namespace Eren5960\Bildir;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener as L;

class Main extends PluginBase implements L{

    /** @var Config */
    private $hak;
    /** @var PREFIX */
    public const PREFIX = "§7[§4BILDIR§7]§f ";
    /** @var Reports */
    private $r;
    
    public function oJ(PlayerJoinEvent $e)
    {
        $oyuncu = strtolower($e->getPlayer()->getName());
        $this->hak = new Config($this->getDataFolder()."data/".strtolower($oyuncu).".yml", Config::YAML);
        if(!$this->hak->get($oyuncu)){
         $this->hak->set($oyuncu, 0);
         $this->hak->save();
         return true;
     }
        if ($this->hak->get($oyuncu."-time")) {
            if($this->hak->get($oyuncu."-time") < time()){
             $this->hak->remove($oyuncu."-time");
             $this->hak->save();
             return true;
          }  
        }
    }
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        @mkdir($this->getDataFolder()."data");
        @mkdir($this->getDataFolder()."reports");
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if($command->getName() == "bildir"){
            if(isset($args[0]) and isset($args[1])){
                $oyuncu = strtolower($sender->getName());
                $this->hak = new Config($this->getDataFolder()."data/".strtolower($oyuncu).".yml", Config::YAML);
                if($this->hak->get($oyuncu) < 5){
                $this->hak->set($oyuncu, $this->hak->get($oyuncu)+1);
                $this->hak->set($oyuncu."-time", strtotime('+1 day'));
                $this->hak->save();
                $this->r = new Config($this->getDataFolder()."reports/".strtolower($oyuncu).".yml", Config::YAML);
                $ilk = explode(":", $args[1]);
                $son = implode(" ", $ilk);
                $this->r->set(strtolower($args[0]), $son);
                $this->r->save();
                $sender->sendMessage(self::PREFIX."§bBildirdiğiniz için teşekkür ederiz!");
                $sender->sendMessage(self::PREFIX."§dYetkililer tarafından incelenecektir!");
                return true;
                }else{
                $sender->sendMessage(self::PREFIX."§4 Günlük sadece 5 kişi bildirebilirsiniz.");
                return false;
                }
            }else{
                $this->yardim($sender);
                return false;
            }
        }
        return true;
    }
    private function yardim($s){
        $s->sendMessage(self::PREFIX);
        $s->sendMessage("§a/bildir <oyuncu> <sebep> : Oyuncuyu bildirmenize yarar!");
        $s->sendMessage("§4DİKKAT: Sebep yazarken boşluk yerine '§a:§4' kullanın!\n§aÖRNEK: §b/bildir Eren5960 çok:küfür:ediyor");
        $s->sendMessage(self::PREFIX);
        return true;
    }
}
