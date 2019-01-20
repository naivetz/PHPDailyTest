<?php
namespace app\controllers;

use yii;
use yii\web\controller;

/**
* 周考
*/
class IndexController extends Controller{
	public $enableCsrfValidation = false;
	public function actionInsert(){
		if (yii::$app->request->ispost) {
			$post = yii::$app->request->post();
			// var_dump($post);die;
			$res = yii::$app->db->createCommand()->insert("users",$post)->execute();
			if ($res) {
				$this->redirect(['index/login']);
			}else{
				echo "注册失败！";
			}
		}else{
			return $this->render("insert");
		}
	}

	public function actionLogin(){
		if (yii::$app->request->ispost) {
			$name = yii::$app->request->post('name');
			$pwd = yii::$app->request->post('pwd');
			$res = yii::$app->db->createCommand("select * from users where '$name' = name and '$pwd' = pwd")->execute();
			if ($res) {
				return $this->render("chess");
			}else{
				echo "用户名或密码错误!";
			}
		}else{
			return $this->render("login");
		}
	}
}

?>