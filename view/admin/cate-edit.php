<?php
    require '../../common/tool.php';
    require '../../common/db.class.php';
    require '../../common/config.php';

    //是否登录
    isLogin();
    $get = $_GET;
    $tag = isset($get['id']) ? $get['id'] : '';
    if(!empty($tag)){
        $conn = new db($config['db']);
        $sql = "select catename from cate where id = " . $tag;
        $date = $conn->getRow($sql);
    }
?>
<!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="./css/font.css">
        <link rel="stylesheet" href="./css/xadmin.css">
        <script type="text/javascript" src="./lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="./js/xadmin.js"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
            <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form">
                  <div class="layui-form-item">
                      <label for="catename" class="layui-form-label">
                          <span class="x-red">*</span>分类名称
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="catename" name="catename" placeholder="<?php echo $date['catename'];?>" required="" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="add" lay-submit="">
                          增加
                      </button>
                  </div>
                  <input type="hidden" id="cate_id" name="cate_id" value="<?php echo $tag;?>" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
              </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //监听提交
                form.on('submit(add)',
                function(data) {
                    console.log(data);
                    //发异步，把数据提交给php
                    $.ajax({
                        url:'../../controller/category.php?tag=update',
                        type:'post',
                        dataType:'json',
                        data:data.field,
                        success:function(res){
                            if(res.code){
                                layer.alert("修改成功", {
                                        icon: 6
                                    },
                                    function() {
                                        //关闭当前frame
                                        xadmin.close();

                                        // 可以对父窗口进行刷新
                                        xadmin.father_reload();
                                    });
                            }else{
                                alert(res.message);
                            }
                        }
                    });
                    return false;
                });

            });</script>
        <script>var _hmt = _hmt || []; (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();</script>
    </body>

</html>
