<?php

namespace wock\pixelblood;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\SpawnParticleEffectPacket;
use pocketmine\player\Player;

class PixelListener implements Listener {

    /** @var PixelBlood */
    private PixelBlood $plugin;

    /** @var bool */
    private bool $bloodEnabled;

    /** @var array */
    public array $bloodEffects;

    public function __construct(PixelBlood $plugin) {
        $this->plugin = $plugin;
        $this->bloodEnabled = true;
        $this->bloodEffects = [];
        $this->loadConfig();
    }

    private function loadConfig() {
        $config = $this->plugin->getConfig();
        $this->bloodEnabled = $config->get("blood-enabled", true);
    }

    public function onDamage(EntityDamageByEntityEvent $event) {
        $entity = $event->getEntity();
        if ($this->bloodEnabled) {
            $this->spawnBloodEffect($entity);
        }
    }

    private function spawnBloodEffect(Entity $entity)
    {
        $particleCount = 10;
        $radius = 0.5;

        $position = $entity->getEyePos();
        $bloodEnabled = $this->plugin->getConfig()->get("blood-enabled", true);


        if ($bloodEnabled) {
            $particleName = $this->plugin->getConfig()->getNested("blood-particle", "minecraft:redstone_ore_dust_particle");
            for ($i = 0; $i < $particleCount; $i++) {
                $offsetX = mt_rand(-$radius * 100, $radius * 100) / 100;
                $offsetY = mt_rand(-$radius * 100, $radius * 100) / 100;
                $offsetZ = mt_rand(-$radius * 100, $radius * 100) / 100;

                $particleX = $position->getX() + $offsetX;
                $particleY = $position->getY() + $offsetY;
                $particleZ = $position->getZ() + $offsetZ;

                $particlePosition = new Vector3($particleX, $particleY, $particleZ);
                $this->spawnParticle($entity, $particleName, $particlePosition);
            }
        }
    }

    /**
     * @param Entity $entity
     * @param string $particleName
     * @param Vector3 $position
     * @param int $radius
     */
    public function spawnParticle(Entity $entity, string $particleName, Vector3 $position, int $radius = 5): void
    {
        $packet = new SpawnParticleEffectPacket();
        $packet->particleName = $particleName;
        $packet->position = $position;

        foreach ($entity->getWorld()->getNearbyEntities($entity->getBoundingBox()->expandedCopy($radius, $radius, $radius)) as $player) {
            if ($player instanceof Player && $player->isOnline()) {
                $player->getNetworkSession()->sendDataPacket($packet);
            }
        }
    }
}
