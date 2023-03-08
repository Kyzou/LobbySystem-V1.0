<?php

namespace Lobby;

use pocketmine\plugin\PluginBase;

use pocketmine\player\Player;

use pocketmine\Server;

use pocketmine\utils\Config;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\event\Cancellable;

use pocketmine\event\Listener;

use pocketmine\item\ItemFactory;

use Lobby\FormAPI\CustomForm;

use Lobby\FormAPI\SimpleForm;

use pocketmine\event\player\PlayerItemUseEvent;

use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\event\player\PlayerQuitEvent;

use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\event\inventory\InventoryTransactionEvent;

use pocketmine\event\player\PlayerDropItemEvent;

class Main extends PluginBase implements Listener {

    

    

    public function onEnable() : void {

        $this->getLogger()->info("The LobbSystem has been activated successfully.");

        $this->getServer()->getPluginManager()->registerEvents($this, $this);

      

        $this->getServer()->getPluginManager()->registerEvents($this,$this);

        @mkdir($this->getDataFolder());

        $this->saveResource("config.yml");

        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);

}

public function onJoin(PlayerJoinEvent $event) {

        $player = $event->getPlayer();

        $name = $event->getPlayer()->getName();

        

        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        

        $event->setJoinMessage($config->get("JoinMessage"));

        $player->setHealth($config->get("Health"));

        

        $this->Main($player);

    }

    

        public function Main(Player $player) {

            $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        $player->getInventory()->clearAll();

        

        

        //////ITEM ID///////

        

        $item1 = ItemFactory::getInstance()->get(369, 0, 1);

        $item2 = ItemFactory::getInstance()->get(345, 0, 1);

        $item1->setCustomName($config->get("Show/Hide Player"));

        $item2->setCustomName($config->get("Games"));

        

        $player->getInventory()->setItem(8, $item1);

        $player->getInventory()->setItem(0, $item2);

        

} 

public function onClick(PlayerItemUseEvent $event) {

    $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        $player = $event->getPlayer();

        $item = $event->getItem();

 ///PUT HERE THE ITEM ID OF LINE 59/60///////////////////

        if($item->getId() == 345) {

            $this->travel($player);

return true;

        }

        if($item->getId() == 369) {

            $this->HideUI($player);

return true;

        }  

}

        

        

   public function travel(Player $player) {

       $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

$form = new SimpleForm(function(Player $player, int $data = null){

            if($data === null){

                return true;

            }

            switch ($data) {

                case 0:

$player->transfer($config->get("Server1IP"));

                break;

                case 1:

                    $player->transfer($config->get("Server2IP"));

                break;

            }

        });

        $form->setTitle($config->get("GamesTitle"));

        $form->addButton($config->get("GameName1"));

        $form->addButton($config->get("GameName2"));

        

        $form->sendToPlayer($player);

        return $form;

    }

    

         public function HideUI(Player $player) {

             $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

$form = new SimpleForm(function(Player $player, int $data = null){

            if($data === null){

                return true;

            }

            switch ($data) {

                case 0:

            $this->showplayer($player);

                break;

                case 1:

            $this->hideplayer($player);

                break;

                

            }

        });

            $form->setTitle($config->get("HideUITitle"));

        

            $form->addButton($config->get("ShowPlayer"));

        

            $form->addButton($config->get("HidePlayer"));

        

            $form->sendToPlayer($player);

            return $form;

            

    }

    

public function showPlayer($player){

    $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

    foreach($this->getServer()->getOnlinePlayers() as $players){

     $player->showPlayer($players); }

       $player->sendMessage($config->get("ShowPlayerMessage"));

        

}

         public function hidePlayer($player){

             $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

             foreach($this->getServer()->getOnlinePlayers() as $players) {         $player->hidePlayer($players); }

        $player->sendMessage($config->get("HidePlayerMessage"));

        

}

}
