<?php

namespace wock\pixelblood\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use wock\pixelblood\PixelBlood;

class PixelBloodCommand extends Command implements PluginOwned {

    /** @var PixelBlood */
    public PixelBlood $plugin;

    public function __construct(PixelBlood $plugin)
    {
        parent::__construct("pixelblood", "Pixel Blood command", "/pixelblood help", ["pb", "pixelb"]);
        $this->setPermission("pixelblood.command");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender->hasPermission("pixelblood.command")){
            $sender->sendMessage("§r§cYou do not have permission to run this command!");
            return false;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage("§r§cYou must run this command in-game");
            return false;
        }

        if (empty($args)) {
            $this->sendCommandList($sender);
            return true;
        }

        $subCommand = array_shift($args);

        switch ($subCommand) {
            case "reload":
                $this->plugin->getConfig()->reload();
                $sender->sendMessage("§r§aConfiguration reloaded.");
                return true;

            case "player":
                $this->togglePixelBlood($sender);
                return true;

            default:
                $sender->sendMessage("§r§cUnknown command. Use /pixelblood for a list of commands.");
                return false;
        }
    }

    private function sendCommandList(Player $player) {
        $player->sendMessage("§r§c§l[!] §r§cPixelBlood Commands:");
        $player->sendMessage("§r§l§c* §r§f/pixelblood reload §8- §fReloads the configuration.");
        $player->sendMessage("§r§l§c* §r§f/pixelblood player §8- §fToggles PixelBlood on/off.");
    }

    /**
     * @throws \JsonException
     */
    private function togglePixelBlood(Player $player) {
        $config = $this->plugin->getConfig();
        $currentValue = $config->get("blood-enabled", true);

        if ($currentValue === true) {
            $config->set("blood-enabled", false);
            $player->sendMessage("§r§l§c[!] §r§cPixelBlood disabled.");
        } else {
            $config->set("blood-enabled", true);
            $player->sendMessage("§r§l§a[!] §r§aPixelBlood enabled.");
        }

        $config->save();
        $config->reload();
    }

    public function getOwningPlugin(): PixelBlood
    {
        return $this->plugin;
    }
}
