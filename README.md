# BannedBroadcast

Version: **1.0.0**

For PocketMine: **1.5** and above (API **1.12.0**)

## License

Copyright (C) 2015 ItalianDevs4PM

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.

## Overview

This simple plugin allows to OPs (or everyone who have ```bb.ban``` and ```bb.whitelist``` permissions) to know when a banned or unwhitelisted player attempts to join.

## Commands

```/bb on|off``` toggles the banned alert

```/unwl on|off``` toggles the unwhitelisted alert

## The config.yml file

This plugin has a config.yml file which allows you to personalize displayed messages.

Let's see how it works:

### Structure of config.yml file

```
---
# BannedBroadcast v1.0.0 by @ItalianDevs4PM <xionbig, fycarman, luca28pet, XEmAX32, AryToNex, EvolSoft>

# Switch for banned messages
# If true the plugin will send messages to players.
banned-switch: true

# Write here the message you want to display when a banned player attempts to join
# Variables: {player} , {ip}
banned-message: "{player} [{ip}] attempted to join but he/she is banned!"

# Switch for unwhitelisted messages
# If true the plugin will send messages to players.
unwhitelisted-switch: true

# Write here the message you want to display when a unwhitelisted player attempts to join
# Variables: {player} , {ip}
unwhitelisted-message: "{player} [{ip}] attempted to join but he/she isn't in the whitelist!"

...
```
### Variables

There are two variables: ```{player}``` and ```{ip}```

```{player}``` shows the banned or unwhitelisted player's nickname.

```{ip}``` shows the banned or unwhitelisted player's IP address.

## Credits

This plugin is developed by @ItalianDevs4PM (@AryToNeX, @EvolSoft, @fycarman, @luca28pet, @XEmAX32, @xionbig)

Follow us on GitHub, PocketMine Forums and Twitter!
