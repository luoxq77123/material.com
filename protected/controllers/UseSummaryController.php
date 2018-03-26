<?php

class UseSummaryController extends Controller
{
    public function actionIndex()
    {
        $page = empty(intval(Yii::app()->request->getParam('page', 1))) ? 1 : intval(Yii::app()->request->getParam('page', 1));
        $limit =30;

        $count = UseSummary::getData();
        $pages = new CPagination($count);
        $pages->pageSize = $limit;

        $data = UseSummary::getData($page,$limit);

        $this->layout='ml';
        $this->render('index',[
            'data'=>$data,
            'pages'=>$pages,
        ]);
    }

    public function actionAdd()
    {
        if(!empty($_POST)){
            UseSummary::putData($_POST);
            $this->redirect(["/usesummary/index"]);exit;
        }
        $this->layout='ml';
        $this->render('add');
    }

    public function actionEdit()
    {
        $id = intval(Yii::app()->request->getParam('id'));
        if(empty($id)){
            $this->redirect(["/usesummary/index"]);exit;
        }
        if(!empty($_POST)){
            UseSummary::editRow($_POST);
            $this->redirect(["/usesummary/index"]);exit;
        }

        $data = Materials::getDataId($id);
        $this->layout='ml';
        $this->render('edit',['data'=>$data,'id'=>$id]);
    }
}