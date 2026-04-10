<?php

// 包含数据库连接
require __DIR__ . '/src/utils/database.php';

try {
    // 获取数据库实例
    $db = Database::getInstance();
    
    // 开始事务
    $db->getConnection()->beginTransaction();
    
    // 更新tokens表中的user_id
    $stmt = $db->query('UPDATE tokens t JOIN users u ON t.user_id = "123e4567e89b12d3a456426655440000" SET t.user_id = u.uuid WHERE u.uid = 1');
    $tokensUpdated = $stmt->rowCount();
    
    // 更新profiles表中的user_id
    $stmt = $db->query('UPDATE profiles p JOIN users u ON p.user_id = "123e4567e89b12d3a456426655440000" SET p.user_id = u.uuid WHERE u.uid = 1');
    $profilesUpdated = $stmt->rowCount();
    
    // 更新user_properties表中的user_id
    $stmt = $db->query('UPDATE user_properties up JOIN users u ON up.user_id = "123e4567e89b12d3a456426655440000" SET up.user_id = u.uuid WHERE u.uid = 1');
    $userPropertiesUpdated = $stmt->rowCount();
    
    // 提交事务
    $db->getConnection()->commit();
    
    // 显示结果
    echo '<!DOCTYPE html>';
    echo '<html lang="zh-CN">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>User ID更新结果</title>';
    echo '<style>';
    echo 'body { font-family: Arial, sans-serif; margin: 20px; }';
    echo 'h1 { color: #333; }';
    echo '.success { color: green; font-weight: bold; }';
    echo '.info { color: blue; }';
    echo 'table { border-collapse: collapse; margin-top: 20px; }';
    echo 'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }';
    echo 'th { background-color: #f2f2f2; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<h1>User ID更新结果</h1>';
    echo '<p class="success">成功更新了 ' . $tokensUpdated . ' 条tokens记录</p>';
    echo '<p class="success">成功更新了 ' . $profilesUpdated . ' 条profiles记录</p>';
    echo '<p class="success">成功更新了 ' . $userPropertiesUpdated . ' 条user_properties记录</p>';
    echo '<p class="info">所有表中的user_id已更新为新的UUID</p>';
    echo '</body>';
    echo '</html>';
    
} catch (Exception $e) {
    // 回滚事务
    $db->getConnection()->rollBack();
    
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
