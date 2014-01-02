<?php
/**
 * SAE 下的配置
 */

$kv = new SaeKV();
// 初始化SaeKV对象
$ret = $kv->init();
$ret = $kv->get('THINKSDK_CONFIG');

return $ret ? unserialize($ret) : array();