<?php

class TestController extends Controller
{
	public function actionIndex()
	{
        $id = md5(123);
        echo Yii::app()->session[$id];
        exit;
        $id = md5(123);
        session_id($id);
        echo $id."<br>";
        Yii::app()->session[$id] = 1234;



        var_dump(1);exit;
        $username = '123';
        $password = '123';
        $data['UserAdmin'] = array(
            'account'=>$username,
            'password'=>$password
        );
        $UserAdmin = new UserAdmin(UserAdmin::LOGIN);
        if (isset($data['UserAdmin'])) {
            $UserAdmin->attributes = $data['UserAdmin'];
            if($UserAdmin->validate()){
                //var_dump($UserAdmin->identity);exit;
                Yii::app()->user->login($UserAdmin->identity);

            }
        }

        $aa = yii::app()->user->getState('account');
        var_dump($aa);
        //$this->createUrl('hxtadm/index')
exit;
        $admin = new UserAdmin();
                if(isset($_POST['Admin'])){
                    $admin->attributes = $_POST['Admin'];
                    if($admin->validate()){
                        Yii::app()->user->login($admin->identity);
                        OperateLog::addLog('login/index','登陆平台');
                        $this->redirect();
                    }
                }

        $userAdmin = new UserAdmin(UserAdmin::CREATE);
        if($_POST){
            $post = $_POST['UserAdmin'];
            $userAdmin->account = $post['account'];
            $userAdmin->password = $post['password'];
            if(!$userAdmin->save()){
                var_dump($userAdmin->errors);
            }else{
                echo "ok";
            }
            exit;
        }



        $this->render('index',array('userAdmin'=>$userAdmin));
	}

    public function actionIndexs()
    {
        $url = 'http://127.0.0.1/yii/mydemo/index.php/test/index';
        $data = array('UserAdmin' =>
            array(
                'account' => '11',
                'password' => '123',
            ));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $return = curl_exec($ch);
        curl_close($ch);
        file_put_contents("as.html", $return);
        var_dump($return);

    }

    public function actionTest()
    {
        $UserAdmin = new UserAdmin(UserAdmin::LOGIN);
                if($_POST){
                    $post = $_POST['UserAdmin'];
                    $UserAdmin->account = $post['account'];
                    $UserAdmin->password = $post['password'];
                    if(!$UserAdmin->save()){
                        var_dump($UserAdmin->errors);
                    }else{
                        echo "ok";
                    }
                    exit;
                }
                $this->render('index',array('userAdmin'=>$UserAdmin));
    }
}