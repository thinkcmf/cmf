<?php
/**
 * SAE 下的动态配置
 */

$kv = new SaeKV();
// 初始化SaeKV对象
$ret = $kv->init();
$ret = $kv->get('DYNAMIC_CONFIG');
return $ret ? unserialize($ret) : array();

?>