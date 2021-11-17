<?php

define('RACE_P',          0);
define('RACE_T',          1);
define('RACE_Z',          2);

define('FORCE_GROUND',    0);
define('FORCE_AIR',       1);

define('TYPE_SMALL',      0);
define('TYPE_MEDIUM',     1);
define('TYPE_LARGE',      2);

// bonus.type
define('BONUS_TYPES', [
  '0' => TApp('Range'),
  '1' => TApp('Damage'),
  '2' => TApp('Cooldown'),
  '3' => TApp('Defense'),
  '20' => TApp('Sight'),
  '21' => TApp('Speed'),
]);

// bonus.scope
define('BONUS_SCOPES', [
  '0' => TApp('Both'),
  '1' => TApp('Ground'),
  '2' => TApp('Air'),
]);

// define('BONUS_GROUND_RANGE',      0);
// define('BONUS_GROUND_DAMAGE',     1);
// define('BONUS_GROUND_COOLDOWN',   2);
// define('BONUS_AIR_RANGE',         10);
// define('BONUS_AIR_DAMAGE',        11);
// define('BONUS_AIR_COOLDOWN',      12);
// define('BONUS_SIGHT',             20);
// define('BONUS_SPEED',             21);

define('ICON_EXPLOSIVE', '/img/Explosive.png');
define('ICON_CONCUSSIVE', '/img/Concussive.png');
define('ICON_SPLASH', '/img/Splash.png');

?>