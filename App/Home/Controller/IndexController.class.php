<?php
namespace Home\Controller;
use Think\Controller,
    Think\Db;

class IndexController extends Controller {

    public function basic() {
        $this->userID = session('USER');

        if($this->userID == '') $this->redirect('Login/index');

        # 将查询句柄赋值给 result对象：
        # - 以方便在接下来使用
        $result = M('users')->where("id=%u",$this->userID)->find();
        $GID = $result['group'];

        if ($GID == 0) {
            $GroupResults = M('group')->where('id > 0')->select();
        }

        if ($GID == 1) {
            $GroupResults = M('group')->where('id > 1')->select();
        }

        return $this->assign([
            'GroupResults' => $GroupResults,
            'SelfGroup' => '个人信息',
            'id' => $this->userID,
            'user' => $result['username']
        ]);
    }

    # ######################### 默认加载 动作：########################## #
    public function index() {
        $this->basic()
            ->display();
    }

    # ################### 用户信息更新 动作： ##################### #
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
            'age'   => I('post.age'),
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


    # ####################  Groups  #################### #
    public function groupBasic($id) {
        $this->basic();
        # search users list results:
        $users = M('users')->where('`group`=%s',$id)->select();

        return $this->assign([
            'users' => $users,
        ]);
    }


    public function groups($gid) {
        $this->groupBasic($gid);
        $this->display();
    }


    # ####################  Users information  #################### #
    public function users($gid = '',$uid = '') {

        $this->groupBasic($gid);
        # search the user information:
        $userResult = M('users')->where('id=%s',$uid)->find();
        if($userResult['sex'] ==1 ){
            $userResult['sex'] = '男';
        }
        else {
            $userResult['sex'] = '女';
        }
        $this->assign('userResult',$userResult)->display();
    }


    public function replace() {

        $result = M('users')->where('id=%s',session('USER'))->find();

        $this->basic();
        $this->assign([
            'userResult' => $result
        ])->display();
    }




}