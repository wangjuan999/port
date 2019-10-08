
    <div class="container">

        <table class="table table-striped" border="1">
            <tr>
                <td>ID</td>
                <td>菜单分类</td>
                <td>菜单标题</td>
                <td>菜单事件</td>
                <td>KEY（Or）URL</td>
                <td>操作</td>
            </tr>
        @foreach($data as $dd)
            <tr>
                <td>{{$dd->id}}</td>
                <td>
                    @if($dd->pid == 0)
                    一级菜单
                    @else
                    二级菜单
                    @endif
                </td>
                <td>{{$dd->cate_name}}</td>
                <td>{{$dd->cate_type}}</td>
                <td>{{$dd->content}}</td>
                <td>
                    <a href="">编辑</a>|
                    <a href="{{url('deletewechatcate')}}?id={{$dd->id}}">删除</a>
                </td>
            </tr>
        @endforeach
        </table>
        <button type="button" class="btn btn-primary" id="cre">添加菜单</button>
        <button type="button" class="btn btn-danger" id="but" href="">一键生成微信菜单</button>


    </div>

<script src="/js/jq.js" charset="utf-8"></script>
<script>
    $(function(){
            $('#but').click(function(){
                location.href="{{url('createwechatcate')}}";
            })
        $('#cre').click(function(){
            location.href="{{url('addWechatCate')}}";
        })
    })
</script>
