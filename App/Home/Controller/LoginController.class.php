<?php
namespace Home\Controller;
use Think\Controller,
    Think\Db;

class LoginController extends Controller {

    public function index() {
        $this->display();
    }

    public function login() {
        # 接收数据：
        $loginName = I('POST.loginName');
        $loginPasd = I('POST.loginPasd');

        $rs = M('users')->where("email = '$loginName' and password = '$loginPasd'")->find();

        if ($rs) {
            session('USER', $rs['id']);
            $this->success('登陆成功', U('Index/index'));
        }
        else {
            $this->error('登陆失败');
        }
    }


    public function logout() {
        session_destroy();
        $this->success('你已退出登录',U('Login/index'));
    }
}