<?php

class MaterialsController extends Controller
{
    public function actionIndex()
    {

        $page = empty(intval(Yii::app()->request->getParam('page', 1))) ? 1 : intval(Yii::app()->request->getParam('page', 1));
        $limit =20;

        $count = Materials::getData();
        $pages = new CPagination($count);
        $pages->pageSize = $limit;

        $data = Materials::getData($page,$limit);

        $this->layout='ml';
        $this->render('index',[
            'data'=>$data,
            'pages'=>$pages,
        ]);
    }

    public function actionAdd()
    {
        if(!empty($_POST)){
            //Materials::putData($_POST);
            echo json_encode(['status'=>0]);exit;
        }

        $this->layout='ml';
        $this->render('add');
    }

    public function actionEdit()
    {
        $id = intval(Yii::app()->request->getParam('id'));
        if(empty($id)){
            $this->redirect(["/materials/index"]);exit;
        }
        if(!empty($_POST)){
            Materials::editRow($_POST);
            $this->redirect(["/materials/index"]);exit;
        }

        $data = Materials::getDataId($id);
        $this->layout='ml';
        $this->render('edit',['data'=>$data,'id'=>$id]);
    }


}