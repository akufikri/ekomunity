<?php return array (
  'App\\Providers\\EventServiceProvider' => 
  array (
    'Illuminate\\Auth\\Events\\Registered' => 
    array (
      0 => 'Illuminate\\Auth\\Listeners\\SendEmailVerificationNotification',
    ),
    'Illuminate\\Auth\\Events\\Login' => 
    array (
      0 => 
      array (
        0 => 'App\\Listeners\\LogAuthActivity',
        1 => 'handleLogin',
      ),
    ),
    'Illuminate\\Auth\\Events\\Logout' => 
    array (
      0 => 
      array (
        0 => 'App\\Listeners\\LogAuthActivity',
        1 => 'handleLogout',
      ),
    ),
    'Illuminate\\Auth\\Events\\Failed' => 
    array (
      0 => 
      array (
        0 => 'App\\Listeners\\LogAuthActivity',
        1 => 'handleFailed',
      ),
    ),
  ),
);