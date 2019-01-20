<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

/**
* 
*/
class Index extends Controller{
	public function index(){
		return view('login');
	}

	//登录
	public function login(){
		$name = input('post.name');
		$pwd = input('post.pwd');
		$res = Db::table('t_user')->where(['name'=>$name,'pwd'=>$pwd])->find();
		if ($res) {
			return $this->success('登陆成功','Index/show');
		}else{
			return $this->error('登陆失败');
		}
	}

	//主页面
	public function show(){
		return view('show');
	}

	//用户展示
	public function user_show(){
		$data = Db::table('t_user')->paginate(5);
		return view('user_show',['data'=>$data]);
	}

	//用户添加
	public function user_add(Request $request){
		if ($request->isPost()) {
			$arr = input('post.');
			$res = Db::table('t_user')->insert($arr);
			if ($res) {
				return $this->success('添加成功','Index/user_show');
			}else{
				return $this->error('添加失败');
			}
		}else{
			return view('user_add');
		}
	}

	//用户删除
	public function user_del(){
		$id = input('get.id');
		$res = db('t_user')->where('id',$id)->delete();
		if ($res) {
			return $this->success('删除成功','Index/user_show');
		}else{
			return $this->error('删除失败');
		}
	}

	//抽奖页面
	public function chou(){
		$data = db('t_prize')->select();
		return view('chou',['data'=>$data]);
	}

	//开始抽奖
	public function chou_start(){
		$arr = db('t_prize')->select();
		$res = array();
		foreach ($arr as $key => $val) {
			for ($i=0; $i < $val['num']; $i++) { 
				$res[] = $val['id'];
			}
		}
		$c = count($res);
		$number = 100-$c;
		for ($i=0; $i < $number; $i++) { 
			$res[] = 0;
		}
		$ran = array_rand($res);
		$ran = $res[$ran];
		//var_dump($ran);die;
		if ($ran == 1) {
			$one = db('t_prize')->where('id',$ran)->find();
			db('t_zhong')->insert(['name'=>$one['name']]);
			return $this->success('恭喜您中奖了,奖品是'.$one['name'],'Index/chou');
		}else if($ran == 2){
			$two = db('t_prize')->where('id',$ran)->find();
			db('t_zhong')->insert(['name'=>$two['name']]);
			return $this->success('恭喜您中奖了,奖品是'.$two['name'],'Index/chou');
		}else if($ran == 3){
			$three = db('t_prize')->where('id',$ran)->find();
			db('t_zhong')->insert(['name'=>$three['name']]);
			return $this->success('恭喜您中奖了,奖品是'.$three['name'],'Index/chou');
		}else if($ran == 0){
			return $this->error('很遗憾没有中奖');
		}
	}

	//展示中奖名单
	public function zhong_show(){
		$data = db('t_zhong')->select();
		return view('zhong_show',['data'=>$data]);
	}

	//中奖名单删除
	public function zhong_del(){
		$id = input('get.id');
		$res = db('t_zhong')->where('id',$id)->delete();
		if ($res) {
			return $this->success('中奖名单删除成功','Index/zhong_show');
		}else{
			return $this->error('中奖名单删除失败');
		}
	}

	//奖品展示
	public function prize_show(){
		$data = db('t_prize')->select();
		return view('prize_show',['data'=>$data]);
	}

	//奖品添加
	public function prize_add(Request $request){
		if ($request->isPost()) {
			$arr = input('post.');
			$res = db('t_prize')->insert($arr);
			if ($res) {
				return $this->success('添加成功','Index/prize_show');
			}else{
				return $this->error('添加失败');
			}
		}else{
			return view('prize_add');
		}
	}

	//奖品删除
	public function prize_del(){
		$id = input('get.id');
		$res = db('t_prize')->where('id',$id)->delete();
		if ($res) {
			return $this->success('删除成功','Index/prize_show');
		}else{
			return $this->error('删除失败');
		}
	}

	//奖品修改
	public function prize_upd(Request $request){
		if ($request->isPost()) {
			$id = input("post.id");
			$arr['name'] = input('post.name');
			$arr['num'] = input('post.num');
			$res = db('t_prize')->where('id',$id)->update($arr);
			if ($res) {
				return $this->success('修改成功','Index/prize_show');
			}else{
				return $this->error('修改失败');
			}
		}else{
			$id = input('get.id');
			$data = db('t_prize')->where('id',$id)->find();
			// var_dump($data);die;
			return view('prize_upd',['data'=>$data]);
		}
	}
}
?>