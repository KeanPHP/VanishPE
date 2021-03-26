<?php

namespace VanishPE;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener
{
    public $isVanish = [];

    public function onEnable()
    {
        $this->getLogger()->info("AdminPE ");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDisable()
    {
        $this->getLogger()->info("AdminPE deactivated");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        $system = TextFormat::BOLD . TextFormat::DARK_RED . "AdminPE >> ";

        switch ($command->getName()) {
            case "vanish":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("vanish.vanish")) {
                        if (!isset($this->isVanish[$sender->getName()])) {
                            foreach ($this->getServer()->getOnlinePlayers() as $onlinePlayer) {
                                $onlinePlayer->hidePlayer($sender);
                            }

                            $sender->sendMessage($system . TextFormat::YELLOW . "
You are now invisible");
                            $this->isVanish[$sender->getName()] = true;
                        } else {
                            foreach ($this->getServer()->getOnlinePlayers() as $onlinePlayer) {
                                $onlinePlayer->showPlayer($sender);
                            }

                            $sender->sendMessage($system . TextFormat::YELLOW . "You are now visible again");
                            $this->isVanish[$sender->getName()] = null;
                        }
                    } else {
                        $sender->sendMessage($system . TextFormat::RED . "You are not allowed to use this commant");
                    }
                } else {
                    $sender->sendMessage($system . TextFormat::YELLOW . "Please run this command in-game");
                }
                break;
        }

        return true;
    }
}