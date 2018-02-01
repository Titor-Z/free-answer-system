<?php
namespace Home\Controller;
use Think\Controller;
use Think\Db;

class RegisterController extends Controller {
    public function index() {
        $this->display();

        /*
         * 当statue收集到结果时
         */
        $state = I('POST.state');

        if ($state){
            $data['email'] = I('POST.email');
            $data['password'] = I('POST.pasd');

            $result = M('users')->add($data);
            if($result === false){
                $this->error("错误");
            } else{
                $this->success('操作成功', U('Login/index'));
            }
        }
    }
}