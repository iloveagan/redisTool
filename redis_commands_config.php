<?php
$redis_commands = array(
    array(
        'name' => 'GET',
        'description' => 'GET 命令用于获取存储在指定键中的值。如果键不存在，则返回 nil。'
    ),
    array(
        'name' => 'SET',
        'description' => 'SET 命令用于设置指定键的值。如果键已经存在，它将被覆盖。'
    ),
    array(
        'name' => 'DEL',
        'description' => 'DEL 命令用于删除指定的键。如果键存在，返回删除的键的数量；如果键不存在，返回 0。'
    ),
    array(
        'name' => 'TTL',
        'description' => 'TTL 命令用于获取指定键的剩余过期时间（秒）。如果键不存在或没有设置过期时间，返回 -1 或 -2。'
    ),
    array(
        'name' => 'SETEX',
        'description' => 'SETEX 命令用于设置指定键的值，并同时设置该键的过期时间（秒）。如果键已经存在，它将被覆盖。'
    ),
    array(
        'name' => 'SMEMBERS',
        'description' => 'SMEMBERS 命令用于返回集合键中的所有成员。如果键不存在，则返回空列表。'
    ),
    array(
        'name' => 'LPUSH',
        'description' => 'LPUSH 命令用于将一个或多个值插入到列表的头部。如果列表不存在，会创建一个新列表。'
    ),
    array(
        'name' => 'RPUSH',
        'description' => 'RPUSH 命令用于将一个或多个值插入到列表的尾部。如果列表不存在，会创建一个新列表。'
    ),
    array(
        'name' => 'LRANGE',
        'description' => 'LRANGE 命令用于返回列表中指定区间内的元素，区间由起始索引和结束索引指定。'
    ),
    array(
        'name' => 'EXPIRE',
        'description' => 'EXPIRE 命令用于为指定键设置过期时间（秒）。如果键存在，返回 1；如果键不存在，返回 0。'
    ),
    array(
        'name' => 'PEXPIRE',
        'description' => 'PEXPIRE 命令用于为指定键设置过期时间（毫秒）。如果键存在，返回 1；如果键不存在，返回 0。'
    ),
    array(
        'name' => 'EXPIREAT',
        'description' => 'EXPIREAT 命令用于为指定键设置一个 UNIX 时间戳作为过期时间。如果键存在，返回 1；如果键不存在，返回 0。'
    )
);
?>