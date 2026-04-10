<?php

// 生成UUID的函数
function generateUUID() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

// 移除UUID中的破折号，使其符合数据库格式
function generateMinecraftUUID() {
    return str_replace('-', '', generateUUID());
}

// 包含数据库连接
require __DIR__ . '/src/utils/database.php';

try {
    // 获取数据库实例
    $db = Database::getInstance();
    
    // 查询所有UUID为空的用户
    $stmt = $db->query('SELECT uid FROM users WHERE uuid IS NULL OR uuid = ""');
    $users = $stmt->fetchAll();
    
    $updatedCount = 0;
    
    // 为每个用户生成UUID并更新
    foreach ($users as $user) {
        $uuid = generateMinecraftUUID();
        $db->query('UPDATE users SET uuid = ? WHERE uid = ?', [$uuid, $user['uid']]);
        $updatedCount++;
    }
    
    // 显示结果
    echo '<!DOCTYPE html>';
    echo '<html lang="zh-CN">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>UUID生成结果</title>';
    echo '<style>';
    echo 'body { font-family: Arial, sans-serif; margin: 20px; }';
    echo 'h1 { color: #333; }';
    echo '.success { color: green; font-weight: bold; }';
    echo '.info { color: blue; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<h1>UUID生成结果</h1>';
    echo '<p class="success">成功为 ' . $updatedCount . ' 个用户生成了UUID</p>';
    echo '<p class="info">所有用户的UUID已补全</p>';
    echo '</body>';
    echo '</html>';
    
} catch (Exception $e) {
    // 显示错误信息
    echo '<!DOCTYPE html>';
    echo '<html lang="zh-CN">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>错误</title>';
    echo '<style>';
    echo 'body { font-family: Arial, sans-serif; margin: 20px; }';
    echo 'h1 { color: #333; }';
    echo '.error { color: red; font-weight: bold; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<h1>错误</h1>';
    echo '<p class="error">处理过程中发生错误: ' . $e->getMessage() . '</p>';
    echo '</body>';
    echo '</html>';
}
