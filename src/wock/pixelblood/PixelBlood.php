<?php

namespace wock\pixelblood;

use pocketmine\plugin\PluginBase;
use wock\pixelblood\Commands\PixelBloodCommand;

class PixelBlood extends PluginBase {

    public function onEnable(): void
    {
       $this->getServer()->getPluginManager()->registerEvents(new PixelListener($this), $this);
       $this->registerCommands();
    }

    public function registerCommands() {
        $this->getServer()->getCommandMap()->registerAll("pixelblood", [
            new PixelBloodCommand($this)
        ]);
    }
}
