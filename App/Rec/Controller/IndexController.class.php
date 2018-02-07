<?php
namespace Rec\Controller;
use Think\Controller;

class IndexController extends Controller {

    public function index() {
        $this->assign([
            'url' => 'register'
        ])->display();
    }

    # ##################### 注册 ####################### #
    public function register() {
        $data = I('post.result');
        $result = M('users')->add($data);
        if($result === false) {
            echo 0;
        } else {
            echo 1;
        }
    }


    # ##################### 答题 ####################### #
    public function answer() {
        ### 接收前台发送来的结果对象
        $result = I('post.result');
        # 如果存在该结果对象，则表示要返回计算的结果
        if($result) {
            echo array_sum($result);
        }
        # 没有接收到结果，表示刚刚打开页面
        else {
            $answer = M('subjects')->where('state=1')->select();
            $this->assign('answer',$answer)->display();
        }
    }

}