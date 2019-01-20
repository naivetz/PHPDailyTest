<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

/**
* 周考三
*/
class Index extends Controller{
	public function index(){
		return view('insert');
	}

	public function add(){
		$data = input('post.');
		// var_dump($data);die;
		//$res = db('marathon_registration')->insertAll($data);
		$res = Db::table('marathon_registration')->insert($data);
		if ($res) {
			return $this->success('添加成功','Index/show');
		}else{
			return $this->error('添加失败');
		}
	}

	public function show(){
		$data = Db::table('marathon_registration')->select();
		return view('show',['data'=>$data]);
	}

	// public function and(){
		
	// }
}


?>