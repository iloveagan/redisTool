<?php
require_once('smarty/libs/Smarty.class.php');

$smarty = new Smarty();
$smarty->setTemplateDir('templates');
$smarty->setCompileDir('templates_c');
$smarty->setConfigDir('configs');
$smarty->setCacheDir('cache');
$smarty->left_delimiter = '<{';
$smarty->right_delimiter = '}>';

// 引入 Redis 配置文件
include 'redis_config.php';
$smarty->assign('redis_groups', $redis_groups);

// 引入 Redis 命令配置文件
include 'redis_commands_config.php';
$smarty->assign('redis_commands', $redis_commands);
?>