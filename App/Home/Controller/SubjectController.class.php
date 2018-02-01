<?php
namespace Home\Controller;
use Think\Controller;
use Think\Db;

class SubjectController extends Controller {
    public function index() {
        # 查询题目列表
        $result = M('subjects')->where('state=1')->select();
        $resultID = array_column($result,'id');
        $resultName = array_column($result,'name');
        $result = array_combine($resultID,$resultName);
        $this->assign('results',$result);
        $this->display();
    }

    public function add() {
        # 查询题目列表
        $result = M('subjects')->where('state=1')->select();
        $result = array_combine(array_column($result,'id'), array_column($result,'name'));
        $this->assign('results',$result);
        $this->display();
    }

    public function submit() {
        $subject_name = I('POST.subjectName');
        $data = [
            'name' => $subject_name
        ];
        $result = M('subjects')->add($data);
        if ($result===false) {
            $this->error('添加失败，请稍后再试','index');
        }
        else {
            $this->success('添加成功','index');
        }
    }

    public function view($id) {
        ### 查询题目列表
        $result = M('subjects')->where('state=1')->select();
        $result = array_combine(array_column($result,'id'), array_column($result,'name'));
        $this->assign('results',$result);


        ### 查询题目名称
        $sub_name = M('subjects')->where('id=%s',$id)->find();
        $this->assign([
            'subID' => $id,
            'subName' => $sub_name['name'],
        ]);
        $this->itemView($id);

        $this->display();
    }

    public function edit($id) {
        ### 查询题目列表
        $result = M('subjects')->where('state=1')->select();
        $result = array_combine(array_column($result,'id'), array_column($result,'name'));
        $this->assign('results',$result);

        ### 查询题目名称
        $sub_name = M('subjects')->where('id=%s',$id)->find();
        $this->assign([
            'subID'     => $sub_name['id'],
            'subName'   => $sub_name['name'],
        ]);

        $this->display();
    }

    public function revise($id) {
        ### 查询题目列表
        $result = M('subjects')->where('state=1')->select();
        $result = array_combine(array_column($result,'id'), array_column($result,'name'));
        $this->assign('results',$result);

        $data = [
            'id'    => $id,
            'name'  => I('POST.subName'),
        ];
        $result = M('subjects')->save($data);
        if ($result === false) {
            $this->error('更新失败',U("edit?id=$id"));
        }
        else {
            $this->success('更新完成',U("view?id=$id"));
        }
    }

    public function del($id) {
        ### 删除题目（隐藏题目）
        # 将当前的题目隐藏，伪删除
        $data = [
            'id'    => $id,
            'state'  => 0,
        ];
        $result = M('subjects')->save($data);
        if ($result === false) {
            $this->error('删除失败',U("view?id=$id"));
        }
        else {
            $this->success('删除成功',U("index"));
        }
    }

    public function itemView($id) {
        ### 查询题目选项
        # 查询题目子项中，ID和当前题目ID一致的所有记录
        $result = M('subject_items')->where("no=%s AND state=1",$id)->select();
        $this->assign('itemRes',$result);
    }
}