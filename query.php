<?php
// 检查是否使用了 PHP 5.2 版本
if (version_compare(PHP_VERSION, '5.2.0', '<')) {
    die('此脚本需要 PHP 5.2 或更高版本。');
}

// 自定义函数获取 POST 数据
function &jy_post() {
    $post = &$_POST;
    return $post;
}

// 引入配置文件
include 'redis_config.php';

// 获取选择的 Redis 连接
$post = jy_post();
$redis_connection_id = $post['redis_connection'];
$selected_connection = null;
foreach ($redis_groups as $group) {
    foreach ($group as $connection) {
        if ($connection['id'] == $redis_connection_id) {
            $selected_connection = $connection;
            break 2;
        }
    }
}

if (!$selected_connection) {
    die('无效的 Redis 连接选择');
}

$host = $selected_connection['host'];
$port = $selected_connection['port'];

// 连接到 Redis
$redis = new Redis();
if (!$redis->connect($host, $port)) {
    die('无法连接到 Redis 服务器：' . $host. ':' . $port);
}

// 获取表单数据
$command = $post['command'];
$key = $post['key'];
$value = isset($post['value']) ? $post['value'] : null;
$expireTime = isset($post['expire-time']) ? (int)$post['expire-time'] : null;
$start = isset($post['start']) ? (int)$post['start'] : null;
$stop = isset($post['stop']) ? (int)$post['stop'] : null;

// 执行 Redis 命令
$result = null;
switch ($command) {
    case 'GET':
        $result = $redis->get($key);
        break;
    case 'SET':
        if ($value) {
            $result = $redis->set($key, $value);
        } else {
            die('执行 SET 命令时需要提供值。');
        }
        break;
    case 'DEL':
        $result = $redis->del($key);
        break;
    case 'TTL':
        $result = $redis->ttl($key);
        break;
    case 'SETEX':
        if ($value && $expireTime) {
            $result = $redis->setex($key, $expireTime, $value);
        } else {
            die('执行 SETEX 命令时需要提供值和过期时间。');
        }
        break;
    case 'SMEMBERS':
        $result = $redis->smembers($key);
        if (is_array($result)) {
            $result = implode(', ', $result);
        }
        break;
    case 'LPUSH':
        if ($value) {
            $result = $redis->lpush($key, $value);
        } else {
            die('执行 LPUSH 命令时需要提供值。');
        }
        break;
    case 'RPUSH':
        if ($value) {
            $result = $redis->rpush($key, $value);
        } else {
            die('执行 RPUSH 命令时需要提供值。');
        }
        break;
    case 'LRANGE':
        if ($start!== null && $stop!== null) {
            $result = $redis->lrange($key, $start, $stop);
            if (is_array($result)) {
                $result = implode(', ', $result);
            }
        } else {
            die('执行 LRANGE 命令时需要提供起始索引和结束索引。');
        }
        break;
    case 'EXPIRE':
        if ($expireTime) {
            $result = $redis->expire($key, $expireTime);
        } else {
            die('执行 EXPIRE 命令时需要提供过期时间（秒）。');
        }
        break;
    case 'PEXPIRE':
        if ($expireTime) {
            $result = $redis->pexpire($key, $expireTime);
        } else {
            die('执行 PEXPIRE 命令时需要提供过期时间（毫秒）。');
        }
        break;
    case 'EXPIREAT':
        if ($expireTime) {
            $result = $redis->expireat($key, $expireTime);
        } else {
            die('执行 EXPIREAT 命令时需要提供 UNIX 时间戳作为过期时间。');
        }
        break;
    default:
        die('不支持的 Redis 命令。');
}

// 输出结果
$output = "<h2>执行结果</h2>";
$output.= "<p>选择的 Redis 连接: ". $selected_connection['name']. "（". $host. ":". $port. "）</p>";
$output.= "<p>命令: $command</p>";
$output.= "<p>键: $key</p>";
if ($value) {
    $output.= "<p>值: $value</p>";
}
if ($expireTime) {
    $output.= "<p>过期时间: $expireTime ";
    if ($command === 'PEXPIRE') {
        $output.= "毫秒";
    } elseif ($command === 'EXPIREAT') {
        $output.= "（UNIX 时间戳）";
    } else {
        $output.= "秒";
    }
    $output.= "</p>";
}
if ($start!== null && $stop!== null) {
    $output.= "<p>起始索引: $start，结束索引: $stop</p>";
}
$output.= "<p>结果: ";
if ($result === false) {
    $output.= "执行失败";
} else {
    $output.= $result;
}
$output.= "</p>";

echo $output;

// 关闭 Redis 连接
$redis->close();
?>
