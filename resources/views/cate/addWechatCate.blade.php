
    <div class="container">

        <form action="{{url('doaddcate')}}" method="post">
            @csrf
            <h3>添加微信菜单</h3>
            <fieldset>
                <div class="form-group">
                    <label for="disabledSelect">选择添加上级菜单</label>
                    <select id="disabledSelect" style="width:700px; height:40px;" name="pid" class="form-control">
                        <option value="">一级菜单</option>
                        <option value="">二级菜单(如果该菜单下要添加二级分类，KEY值可为空)</option>
                    @foreach($data as $dd)
                        <option style="color:red;" value="{{$dd->id}}">（二级分类）&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$dd->cate_name}}</option>
                @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="disabledSelect">选择微信菜单类型</label>
                    <select id="disabledSelect"  style="width:700px; height:40px;" name="cate_type" class="form-control">
                        <option value="click">点击事件</option>
                        <option value="view">跳转事件</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="disabledTextInput">输入微信菜单标题</label>
                    <input type="text"  style="width:700px; height:40px;" id="disabledTextInput" name="cate_name" class="form-control" placeholder="">
                </div>

                <div class="form-group">
                    <label for="disabledTextInput">填写KEY值(关键字)Or(URL)</label>
                    <input type="text"  style="width:700px; height:40px;" id="disabledTextInput" name="content" class="form-control" placeholder="">
                </div>

                <button type="submit" class="btn btn-primary" style="width:200px; height:40px;">创建菜单(Submit)</button>
            </fieldset>
        </form>

    </div>

<script src="/jquery-3.3.1.min.js" charset="utf-8"></script>
<script>
        $(function(){

        })
</script>
