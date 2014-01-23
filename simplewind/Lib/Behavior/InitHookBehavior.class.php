<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2013 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 初始化钩子信息
class InitHookBehavior extends Behavior {

    // 行为扩展的执行入口必须是run
    public function run(&$content){
        
        $data = S('hooks');
        if(!$data){
            $hooks = M('Hooks')->getField('name,plugins');
            foreach ($hooks as $key => $value) {
                if($value){
                    $map['status']  =   1;
                    $names          =   explode(',',$value);
                    $map['name']    =   array('IN',$names);
                    $data = M('Plugins')->where($map)->getField('id,name');
                   
                    if($data){
                        $plugins = array_intersect($names, $data);
                        Hook::add($key,$plugins);
                    }
                }
            }
            S('hooks',Hook::get());
        }else{
            Hook::import($data,false);
        }
    }
}