<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$php_version = PHP_VERSION;
$server_software = $_SERVER['SERVER_SOFTWARE'];
$mysql_version = getMysqlVersion();
$redis_version = getRedisVersion();

echo '<h2>Docker services:</h2>';
echo '<ul>';
    echo "<li>PHP: $php_version</li>";
    echo "<li>Nginx: $server_software</li>";
    echo "<li>MySQL: $mysql_version</li>";
    echo "<li>Redis: $redis_version</li>";
echo '</ul>';

echo '<h2>Installed extensions</h2>';
printExtensions();

/**
 * Get MySQL version
 * 
 * @return string
 */
function getMysqlVersion()
{
    if (extension_loaded('PDO_MYSQL')) {
        try {
            $dbh = new PDO('mysql:host=mysql;dbname=mysql', 'root', 'password');
            $sth = $dbh->query('SELECT VERSION() as version');
            $info = $sth->fetch();

            return $info['version'];
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    } else {
        return 'PDO_MYSQL ×';
    }
}

/**
 * Get Redis version
 * 
 * @return string
 */
function getRedisVersion()
{
    if (extension_loaded('redis')) {
        try {
            $redis = new Redis();
            $redis->connect('redis', 6379);
            $info = $redis->info();

            return $info['redis_version'];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    } else {
        return '×';
    }
}

/**
 * Print all installed extensions
 * 
 * @return void
 */
function printExtensions()
{
    echo '<ol>';
    foreach (get_loaded_extensions() as $name) {
        $version = phpversion($name);
        echo "<li>$name: $version</li>";
    }
    echo '</ol>';
}
