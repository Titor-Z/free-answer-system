<?php
namespace Home\Controller;
use Think\Controller,
    Think\Db;

class IndexController extends Controller {

    ### 默认加载 动作：
    public function index() {
        $this->userID = session('USER');

        if($this->userID == '') $this->redirect('Login/index');

        # 将查询句柄赋值给 result对象：
        # - 以方便在接下来使用
        $this->result = M('users')->where("id=%u",$this->userID)->find();


        ### 分组操作
        $user_groups = M('group')->select();
        $id_group = array_column($user_groups, 'id');
        $name_group = array_column($user_groups, 'name');

        # 将查询出来的2维数组，变为正常使用的1维数组
        $groups=array_combine($id_group,$name_group);


        ### 输出操作
        $this->assign([
            'userID'    => $this->result['id'],
            'userName'  => $this->result['username'],
            'userEmail' => $this->result['email'],
            'userSex'   => $this->result['sex'],
            'userGroup' => $this->result['group']
        ])->display();
    }

    # 用户信息更新 动作：
    public function userUpdate() {

        $result = M('users')->where("id=%s",I('POST.id'))->find();

        # 判断是否要更新密码
        if (I('POST.password')=='' || I('POST.password')==NULL || I('POST.password')==false) {
            $password = $result['password'];
        }
        else{
            $password = I('POST.password');
        }

        ### 整合接收的数据，进行更新操作
        $userNewInfo = [
            'id'       => I('POST.id'),
            'username' => I('POST.username'),
            'sex' => I('POST.sex'),
            'group' => I('POST.group'),
            'password' => $password,
        ];

        $userID = I('POST.id');
        $result = M('users')->save($userNewInfo);
        if ($result === false) {
            $this->error("更新失败");
        }
        else {
            $this->success('更新完成',U('index?group=1&user=true'));
        }
    }


}