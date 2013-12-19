<?php

/* * 
 * 系统权限配置，用户角色管理
 */

class RbacAction extends AdminbaseAction {

    protected $User, $Role, $Access, $Role_user;

    function _initialize() {
        parent::_initialize();
        $this->Role = D("Role");
    }

    /**
     * 角色管理，有add添加，edit编辑，delete删除
     */
    public function index() {
        $data = $this->Role->order(array("listorder" => "asc", "id" => "desc"))->select();
        $this->assign("roles", $data);
        $this->display();
    }

    /**
     * 添加角色
     */
    public function roleadd() {
        if (IS_POST) {
            if ($this->Role->create()) {
                if ($this->Role->add()) {
                    $this->assign("jumpUrl", U("Rbac/rolemanage"));
                    $this->success("添加角色成功",U("rbac/index"));
                } else {
                    $this->error("添加失败！");
                }
            } else {
                $this->error($this->Role->getError());
            }
        } else {
            $this->display();
        }
    }

    /**
     * 删除角色
     */
    public function roledelete() {
    	$users_obj=new UsersModel();
        $id = (int) $this->_get("id");
        if ($id == 1) {
            $this->error("超级管理员角色不能被删除！");
        }
        $count=$users_obj->where("role_id=$id")->count();
        if($count){
        	$this->error("该角色已经有用户！");
        }else{
        	$status = $this->Role->delete($id);
        	if ($status) {
        		$this->success("删除成功！", U('Rbac/index'));
        	} else {
        		$this->error("删除失败！");
        	}
        }
        
    }

    /**
     * 编辑角色
     */
    public function roleedit() {
        $id = (int) $this->_get("id");
        if ($id == 0) {
            $id = (int) $this->_post("id");
        }
        if ($id == 1) {
            $this->error("超级管理员角色不能被修改！");
        }
        if (IS_POST) {
            $data = $this->Role->create();
            if ($data) {
                if ($this->Role->save($data)) {
                    $this->success("修改成功！", U('Rbac/index'));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error($this->Role->getError());
            }
        } else {
            $data = $this->Role->where(array("id" => $id))->find();
            if (!$data) {
                $this->error("该角色不存在！");
            }
            $this->assign("data", $data);
            $this->display();
        }
    }

    /**
     * 角色授权
     */
    public function authorize() {
        $this->Access = D("Access");
        if (IS_POST) {
            $roleid = (int) $this->_post("roleid");
            if(!$roleid){
                $this->error("需要授权的角色不存在！");
            }
            if (is_array($_POST['menuid']) && count($_POST['menuid'])>0) {
                //取得菜单数据
                $menuinfo = M("Menu")->select();
                foreach ($menuinfo as $_v) {
                    $menu_info[$_v["id"]] = $_v;
                }
                C('TOKEN_ON', false);
                $addauthorize = array();
                //检测数据合法性
                foreach ($_POST['menuid'] as $menuid) {
                    $info = array();
                    $info = $this->get_menuinfo((int) $menuid, $menu_info);
                    if($info == false){
                        continue;
                    }
                    $info['role_id'] = $roleid;
                    $data = $this->Access->create($info);
                    if (!$data) {
                        $this->error($this->Access->getError());
                    } else {
                        $addauthorize[] = $data;
                    }
                }
                C('TOKEN_ON', true);
                $this->Access->where("role_id=$roleid")->delete();
                
                if($this->Access->rbac_authorize($roleid,$addauthorize)){
                    $this->success("授权成功！", U("Rbac/index"));
                }else{
                    $this->error("授权失败！");
                }
            }else{
                //当没有数据时，清除当前角色授权
                $this->Access->where(array("role_id" => $roleid))->delete();
                $this->error("没有接收到数据，执行清除授权成功！");
            }
        } else {
            //角色ID
            $roleid = (int) $this->_get("id");
            if (!$roleid) {
                $this->error("参数错误！");
            }
            import("Tree");
            $menu = new Tree();
            $menu->icon = array('│ ', '├─ ', '└─ ');
            $menu->nbsp = '&nbsp;&nbsp;&nbsp;';
            $result = F("Menu");
            $priv_data = $this->Access->where(array("role_id" => $roleid))->select(); //获取权限表数据

            foreach ($result as $n => $t) {
                $result[$n]['checked'] = ($this->is_checked($t, $roleid, $priv_data)) ? ' checked' : '';
                $result[$n]['level'] = $this->get_level($t['id'], $result);
                $result[$n]['parentid_node'] = ($t['parentid']) ? ' class="child-of-node-' . $t['parentid'] . '"' : '';
            }
            $str = "<tr id='node-\$id' \$parentid_node>
                       <td style='padding-left:30px;'>\$spacer<input type='checkbox' name='menuid[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td>
	    			</tr>";
            $menu->init($result);
            $categorys = $menu->get_tree(0, $str);

            $this->assign("categorys", $categorys);
            $this->assign("roleid", $roleid);
            $this->display();
        }
    }

    /**
     * 设置栏目权限 
     */
    public function setting_cat_priv() {
        if (IS_POST) {
            $roleid = $this->_post("roleid");
            $priv = array();
            foreach ($_POST['priv'] as $k => $v) {
                foreach ($v as $e => $q) {
                    $priv[] = array("roleid" => $roleid, "catid" => $k, "action" => $q, "is_admin" => 1);
                }
            }
            C('TOKEN_ON', false);
            //循环验证每天数据是否都合法
            foreach ($priv as $r) {
                $data = D("Category_priv")->create($r);
                if (!$data) {
                    $this->error(D("Category_priv")->getError());
                } else {
                    $addpriv[] = $data;
                }
            }
            C('TOKEN_ON', true);
            //设置权限前，先删除原来旧的权限
            M("Category_priv")->where(array("roleid" => $roleid))->delete();
            //添加新的权限数据，使用D方法有操作记录产生
            D("Category_priv")->addAll($addpriv);
            $this->success("权限赋予成功！");
        } else {
            import('Tree');
            $roleid = $this->_get("roleid");
            $categorys = F("Category");
            $tree = new Tree();
            $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
            $category_priv = M("Category_priv")->where(array("roleid" => $roleid))->select();
            $priv = array();
            foreach ($category_priv as $k => $v) {
                $priv[$v['catid']][$v['action']] = true;
            }

            foreach ($categorys as $k => $v) {
                if ($v['type'] == 1 || $v['child']) {
                    $v['disabled'] = 'disabled';
                    $v['init_check'] = '';
                    $v['add_check'] = '';
                    $v['delete_check'] = '';
                    $v['listorder_check'] = '';
                    $v['push_check'] = '';
                    $v['move_check'] = '';
                } else {
                    $v['disabled'] = '';
                    $v['add_check'] = isset($priv[$v['catid']]['add']) ? 'checked' : '';
                    $v['delete_check'] = isset($priv[$v['catid']]['delete']) ? 'checked' : '';
                    $v['listorder_check'] = isset($priv[$v['catid']]['listorder']) ? 'checked' : '';
                    $v['push_check'] = isset($priv[$v['catid']]['push']) ? 'checked' : '';
                    $v['move_check'] = isset($priv[$v['catid']]['remove']) ? 'checked' : '';
                    $v['edit_check'] = isset($priv[$v['catid']]['edit']) ? 'checked' : '';
                }
                $v['init_check'] = isset($priv[$v['catid']]['init']) ? 'checked' : '';
                $categorys[$k] = $v;
            }
            $str = "<tr>
	<td align='center'><input type='checkbox'  value='1' onclick='select_all(\$catid, this)' ></td>
	<td>\$spacer\$catname</td>
	<td align='center'><input type='checkbox' name='priv[\$catid][]' \$init_check  value='init' ></td>
	<td align='center'><input type='checkbox' name='priv[\$catid][]' \$disabled \$add_check value='add' ></td>
	<td align='center'><input type='checkbox' name='priv[\$catid][]' \$disabled \$edit_check value='edit' ></td>
	<td align='center'><input type='checkbox' name='priv[\$catid][]' \$disabled \$delete_check  value='delete' ></td>
	<td align='center'><input type='checkbox' name='priv[\$catid][]' \$disabled \$listorder_check value='listorder' ></td>
	<td align='center'><input type='checkbox' name='priv[\$catid][]' \$disabled \$push_check value='push' ></td>
	<td align='center'><input type='checkbox' name='priv[\$catid][]' \$disabled \$move_check value='remove' ></td>
            </tr>";
            $tree->init($categorys);
            $categorydata = $tree->get_tree(0, $str);
            $this->assign("categorys", $categorydata);
            $this->assign("roleid", $roleid);
            $this->display("categoryrbac");
        }
    }

    /**
     *  检查指定菜单是否有权限
     * @param array $data menu表中数组
     * @param int $roleid 需要检查的角色ID
     */
    protected function is_checked($data, $roleid, $priv_data) {
        /* $priv_arr = array('app', 'model', 'action');
        if ($data['app'] == '') {
            return false;
        }
        foreach ($data as $key => $value) {
            if (!in_array($key, $priv_arr)) {
                unset($data[$key]);
            }
        }
        $data['role_id'] = $roleid;
        $data["g"] = $data['app'];
        $data["m"] = $data['model'];
        $data["a"] = $data['action'];
        unset($data['app']);
        unset($data['model']);
        unset($data['action']);
        print_r($data);
        $info = in_array($data, $priv_data);
        if ($info) {
            return true;
        } else {
            return false;
        } */
    	
    	$priv_arr = array('app', 'model', 'action');
    	if ($data['app'] == '') {
    		return false;
    	}
    	$mdata['role_id'] = $roleid;
    	$mdata["g"] = $data['app'];
    	$mdata["m"] = $data['model'];
    	$mdata["a"] = $data['action'];
    	$info = in_array($mdata, $priv_data);
    	if ($info) {
    		return true;
    	} else {
    		return false;
    	}
    }

    /**
     * 获取菜单深度
     * @param $id
     * @param $array
     * @param $i
     */
    protected function get_level($id, $array = array(), $i = 0) {
        foreach ($array as $n => $value) {
            if ($value['id'] == $id) {
                if ($value['parentid'] == '0')
                    return $i;
                $i++;
                return $this->get_level($value['parentid'], $array, $i);
            }
        }
    }

    /**
     * 获取菜单表信息
     * @param int $menuid 菜单ID
     * @param int $menu_info 菜单数据
     */
    protected function get_menuinfo($menuid, $menu_info) {
        $info = $menu_info[$menuid];
        if(!$info){
            return false;
        }
        $return['g'] = $info['app'];
        $return['m'] = $info['model'];
        $return['a'] = $info['action'];
        return $return;
    }
    
    public function member(){
    	$role_id=$_GET['id'];
    	$users_obj=new UsersModel();
    	$join = C('DB_PREFIX').'role as b on a.role_id =b.id';
    	$lists=$users_obj->alias("a")->join($join)->where("role_id=$role_id and a.user_status=1")->select();
    	$this->assign("lists",$lists);
    	$this->display();
    	
    }

}

?>
