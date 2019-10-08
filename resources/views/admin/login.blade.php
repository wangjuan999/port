<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css?v=4.1.0" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">h</h1>

            </div>
            <h3>欢迎使用 hAdmin</h3>

            <form class="m-t" role="form"  action="{{url('admin/login_do')}}">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="用户名" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="密码" required="">
                </div>
                <div class="form-group">
                    <input type="text" name="" class="form-control" placeholder="验证码">
                    <input type="button" name="" id="send" class="btn" value="发送验证码">
                </div>
                
                
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>


                <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a></br>|<a href="">换种方式登录？扫码进行管理员绑定</a>
                </p>
                <div>
                    
                    <img src="/3.jpg">
                    <p class="text-muted text-center"><small>请关注公众号后进行管理员绑定</small> </p>
                </div>
            </form>
        </div>
    </div>

    <!-- 全局js -->
    <script src="/js/jquery.min.js?v=2.1.4"></script>
    <script src="/js/bootstrap.min.js?v=3.3.6"></script>
<!-- <script src="/js/jq.js"></script> -->
        <script type="text/javascript">
            $("#send").click(function(){
            // alert(34);
            //获取用户名密码
            var username = $("[name=username]").val();
            var password = $("[name=password]").val();
            ///向后台发送ajax
            $.ajax({
                url:"{{url('admin/send')}}",
                dataType:"json",
                data:{username:username,password:password},
                success:function(res=1){
                    alert('发送成功，请前往微信公众号查看验证码，有效期为两分钟');
                }
            })

        })
        </script>
        
    

</body>

</html>
