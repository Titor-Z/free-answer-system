<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户注册</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <style>
        .form-center{
            position: absolute;
            top: 20%;
        }
        .modal {
            background: rgba(0,0,0,.5);
        }
        .modal-dialog {
            margin-top: 70%;
        }
        .display {
            display: block;
        }
        .alert {
            margin: 8px 0 0 0;
            height: 16px;
            line-height: 16px;
            padding: 8px;
            box-sizing: content-box;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <form class="form-horizontal form-center col-sm-4 col-sm-offset-4 col-xs-9 col-xs-offset-1" name="registerForm" action="<?php echo U('register');?>" method="post">
        <input name="state" type="hidden" value="toRegister">

        <div class="form-group">
            <label for="username" class="col-sm-2 control-label hidden-xs">姓名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control text-center" id="username" name="username" placeholder="请输入姓名" data-length="5" required>
                <div class="alert alert-danger hidden" role="alert">...</div>
            </div>
        </div>

        <div class="form-group">
            <label for="mobile" class="col-sm-2 control-label hidden-xs">手机号</label>
            <div class="col-sm-10">
                <input type="number" class="form-control text-center" id="mobile" name="mobile" placeholder="请输入你的手机号码" data-length="11" required>
                <div class="alert alert-danger hidden" role="alert">...</div>
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="col-sm-2 control-label hidden-xs">邮箱</label>
            <div class="col-sm-10">
                <input type="email" class="form-control text-center" id="email" name="email" placeholder="请输入你的邮箱" required>
                <div class="alert alert-danger hidden" role="alert">...</div>
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="col-sm-2 control-label hidden-xs">性别</label>
            <div class="col-sm-10 col-sm-offset-2">
                <select class="form-control tetxt-center" id="sex" name="sex" required>
                    <option value="1">男</option>
                    <option value="0">女</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="age" class="col-sm-2 control-label hidden-xs">年龄</label>
            <div class="col-sm-10">
                <input type="number" class="form-control text-center" id="age" name="age" placeholder="请输入你的年龄" data-length="3" required>
                <div class="alert alert-danger hidden" role="alert">...</div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 col-xs-12">
                <button type="button" class="btn btn-primary col-xs-12">注册并开始答题</button>
            </div>
        </div>

        <!-- 结果模态框 Start. -->
        <div class="modal bs-example-modal-lg col-xs-12" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div>
                            <h3 class="text-danger">注册成功<br>是否前往答题</h3>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo U('Rec/Index/answer');?>" class="btn btn-primary">是</a>
                        <a href="javascript:void(0)" class="btn btn-default" data-close="modal">否</a>
                    </div>
                </div>
            </div>
        </div> <!-- 结果模态框 End. -->

    </form> <!-- 登录表单结束 -->
</div>

<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script>
    (function () {
        // 检测姓名
        var NameCheck = function (name) {
                var GetLength = name.data('length'),
                    length = name.val().length;

                if (length == 0 || length == '' || length == null){
                    PromptBox(name, 1,'请输入用户名');
                }
                else if (length > GetLength) {
                    PromptBox(name, 1, "用户名需小于"+GetLength+"位");
                }
                else{
                    PromptBox(name, 0,'');
                    return 1;
                }
            },

            // 检测手机号
            MobileCheck = function (name) {
                var GetLength = name.data('length'),
                    length = name.val().length;

                if (length == 0 || length == '' || length == null){
                    PromptBox(name, 1,'请输入手机号');
                }
                else if(length != GetLength) {
                    PromptBox(name, 1,'手机号需是'+GetLength+'位的号码');
                }
                else if (length > GetLength) {
                    PromptBox(name, 1, "手机号需小于"+GetLength+"位");
                }else if (!IsTel(name.val())) {
                    PromptBox(name, 1, "请输入正确格式的手机号");
                }
                else{
                    PromptBox(name, 0,'');
                    return 1;
                }
            },

            // 检测邮箱
            EmailCheck = function (name) {
                var length = name.val().length;
                if(length == '' || length == null || length == false) {
                    return 0;
                }
                else {
                    return name.val();
                }
            },

            // 检测年龄
            AgeCheck = function (name) {
                var GetLength = name.data('length'),
                    length = name.val().length;

                if (length == '' || length == null){
                    PromptBox(name, 1,'请输入你的年龄');
                }
                else if(length > GetLength) {
                    PromptBox(name, 1,'年龄不能大于'+GetLength+'位');
                }
                else{
                    PromptBox(name, 0,'');
                    return 1;
                }
            },

            // 提示框
            PromptBox = function (object,state, content) {
                if (state === 1 || state === true){
                    object.next().removeClass('hidden').text(content);
                }
                else{
                    object.next().addClass('hidden');
                }
            },

            // 检测手机号码是否合法
            IsTel = function (mobileNumber) {
                var reg = new RegExp(/^1[3-578]\d{9}$/),
                    CheckResult = mobileNumber.match(reg);
                if (CheckResult) {
                    return 1;
                }
                else{
                    return 0;
                }
            };

        var name    = $("#username"),
            mobile  = $("#mobile"),
            button  = $("button"),
            email   = $("#email"),
            sex     = $("#sex"),
            age     = $("#age"),
            modal   = $(".modal"),
            title   = modal.find('h3');

        // 最后提交时进行循环检测
        button.click(function () {
            if (NameCheck(name) && MobileCheck(mobile) && AgeCheck(age)){
                button.attr('disabled', true);
                var result = {
                    'username' : name.val(),
                    'mobile': mobile.val(),
                    'email': EmailCheck(email),
                    'sex': sex.val(),
                    'age' : age.val()
                };

                $.post("<?php echo U('Rec/Index/register');?>",{'result':result},function (res) {

                    modal.removeClass('hidden').addClass('display');

                    if(res == 1 || res === true) {
                        button.attr('disabled',false);
                        title.html("注册成功<br>是否前往答题");
                        return false;
                    }
                    // 失败情况
                    else {
                        var CloseHtml = "<a href=\"javascript:void(0)\" class=\"btn btn-default\" data-close=\"modal\">确定</a>";
                        modal.find(".modal-footer").html(CloseHtml);

                        button.attr('disabled',true);
                        title.html("注册失败<br>点击重新注册");
                        CloseModal(modal);
                    }
                });
            }
            else{
                button.attr('disabled', false);
                NameCheck(name);
                MobileCheck(mobile);
                AgeCheck(age);
            }
        });

        name.blur(function () {
            NameCheck(name);
        });

        mobile.blur(function () {
            MobileCheck(mobile);
        });

        age.blur(function () {
            AgeCheck(age);
        });


        function CloseModal(AreaName) {
            var closeBtn = AreaName.find("[data-close]"),
                closeObject = closeBtn.data('close');
            closeBtn.click(function () {
                modal.removeClass('display').addClass('hidden');
                button.attr('disabled',false);
            });
        }
    })();
</script>
</body>
</html>