<?php
namespace Home\Controller;
use Think\Controller;

class SubjectItemController extends Controller
{

    # ################################################ #
    /*
     * id 题目id号码
     * s statue 当前的执行的动作
     * - 有两个值：1、add 添加，2、edit 修改。默认为 add
     */
    public function details($id,$s='add'){
        ### 查询题目列表
        $result = M('subjects')->where('state=1')->select();
        $result = array_combine(array_column($result,'id'), array_column($result,'name'));
        $this->assign('results',$result);

        switch ($s){
            case 'add':
                /*
                 * 展示添加选项视图
                 *  - 添加一个钩子，在同样的视图中完成分离操作
                 *    改变form的提交状态为 add
                 *  - id 值为题目id值，因为在接下来的操作中，需要为添加的选项
                 *    关联题目号（外键）
                 *  - 它接下来的操作为 save方法
                */
                $this->assign([
                    'id'    => $id,
                    'state' => 'add',
                ]);
                break;

            case 'edit':
                /*
                 * 展示添加选项视图
                 * - 添加一个钩子，在同样的视图中完成分离操作
                 *   改变form的提交状态为 edit
                 */
                $result = M('subject_items')->where('id=%s',$id)->find();
                $no = I('GET.no');
                $this->assign([
                    'result'    => $result,
                    'state'     => "edit&no=$no"
                ]);
                break;
        }

        $this->display();

    }

    # ###################################################### #

    public function save($id,$s){
        ### 分状态进行数据保存处理
        # 如果通过地址栏获取到 s(state)的状态为 add，
        # 则进行添加操作
        switch ($s) {
            case 'add':
                $data = [
                    'no'    => $id,
                    'name'  => I('POST.name'),
                    'grade' => I('POST.grade'),
                ];

                $result = M('subject_items')->add($data);
                if ($result === false) {
                    $this->error('添加失败，请稍后重试');
                }
                else{
                    $this->error('添加成功',U("Subject/view?id=$id"));
                }

                break;

            case 'edit':
                $data = [
                    'id'    => $id,
                    'name'  => I('POST.name'),
                    'grade' => I('POST.grade'),
                ];

                # 题目id
                $no = I('GET.no');

                $result = M('subject_items')->save($data);
                if ($result === false) {
                    $this->error('修改失败，请稍后重试！', U("details?id=$id&s=edit"));
                } else {
                    $this->success('修改成功', U("Subject/view?id=$no"));
                }
                break;

        }

    }

    # ################################################## #

    /*
     *
     */
    public function del() {
        $item_arr = I('POST.check/a');
        if ($item_arr) {
            foreach ($item_arr as $val) {
                $result = M('subject_items')->save([
                    'state' => '0',
                    'id'    => $val
                ]);
            }

            if ($result === false){
                $this->error('删除失败，请稍后重试');
            }
            else {
                $this->success('删除成功，正在跳转中。。');
            }
        }
        else {
            $this->error('请选择你要删除的项');
        }
    }

}