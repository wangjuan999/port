<?php 
//递归创建分类树形结构
function createTree($data,$parent_id=0,$level=1)
{
	//1定义一个容器(新数组)
	static $new_arr = [];
	//2遍历数据一条条比对
	foreach ($data as $key => $value) {
		//3找parent_id = 0
		if($value->parent_id == $parent_id){
			//增加级别字段
			$value->level = $level;
			//4 找到之后放到新数组里
			$new_arr[] = $value;
			//5 调用程序自身递归找子集
			createTree($data,$value->cate_id,$level+1);
		}
	}
	return $new_arr;
}

/**
 * 递归排序 生成属性结构 子类放入son字段
 * @param  [type]  $data      [description]
 * @param  integer $parent_id [description]
 * @return [type]             [description]
 */
function createTreeBySon($data,$parent_id=0)
{
	//1 定义新数组
	$new_arr = [];
	//2 先找1级分类
	foreach ($data as $key => $value) {
		//判断如果是1级分类
		if($value['parent_id'] == $parent_id){
			//找到了 放到新数组
			$new_arr[$key] = $value;
			//找子分类 放到上级分类的son下标下
			$new_arr[$key]['son'] = createTreeBySon($data,$value['cat_id']);
		}
	}
	return $new_arr;
}



 ?>