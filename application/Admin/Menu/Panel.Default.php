<?php	return array (
  'app' => 'Admin',
  'model' => 'Panel',
  'action' => 'default',
  'data' => '',
  'type' => '0',
  'status' => '1',
  'name' => '设置',
  'icon' => 'cogs',
  'remark' => '',
  'listorder' => '0',
  'items' => 
  array (
    0 => 
    array (
      'app' => 'Admin',
      'model' => 'Setting',
      'action' => 'default',
      'data' => '',
      'type' => '0',
      'status' => '1',
      'name' => '个人信息',
      'icon' => NULL,
      'remark' => '',
      'listorder' => '0',
      'items' => 
      array (
        0 => 
        array (
          'app' => 'Admin',
          'model' => 'User',
          'action' => 'userinfo',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '修改信息',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        1 => 
        array (
          'app' => 'Admin',
          'model' => 'Setting',
          'action' => 'password',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '修改密码',
          'icon' => NULL,
          'remark' => '',
          'listorder' => '0',
        ),
      ),
    ),
    1 => 
    array (
      'app' => 'Admin',
      'model' => 'setting',
      'action' => 'site',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '网站信息',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
    ),
    2 => 
    array (
      'app' => 'Admin',
      'model' => 'setting',
      'action' => 'clearcache',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '清除缓存',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
    ),
  ),
);?>