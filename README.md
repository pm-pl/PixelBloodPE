# PixelBlood

PixelBlood is a plugin for [PocketMine-MP](https://pmmp.io/) that adds realistic blood particle effects when entities are damaged.

## Features

- Customizable blood particle effects.
- Realistic particle spawning based on entity hit positions.
- Configurable options to enable/disable blood effects.

## Requirements

- PocketMine-MP API 5.x.x

## Installation

1. Download the latest release of PixelBlood from the [releases page](https://github.com/iLVOEWOCK/PixelBloodPE/releases).
2. Place the `PixelBlood.phar` file into the `plugins` folder of your PocketMine-MP server.
3. Start the server. PixelBlood will automatically be enabled.

## Configuration

The configuration file `config.yml` can be found in the `plugin_data/PixelBlood` directory. It contains the following options:

```yaml
# Enables or disables the blood effects
blood-enabled: true

# The particle name to be used for blood effects
blood-particle: minecraft:redstone_ore_dust_particle
```

## To-Do

[ ] Make effects toggable per player\
[ ] Toggable per mob\
[ ] Add spray effect when killing mob/player
