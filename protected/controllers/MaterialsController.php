<?php

class MaterialsController extends Controller
{

    public function actionPutStorage()
    {

        if(!empty($_POST)){
            Materials::putData($_POST);

        }

        $this->layout='ml';
        $this->render('put');
    }

    public function actionIndex()
    {
        $data = Materials::getData();
        $this->layout='ml';
        $this->render('index',['data'=>$data]);
    }
}