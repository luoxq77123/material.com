<?php

class UseSummaryController extends Controller
{
    public function actionIndex()
    {

    }

    public function actionAdd()
    {
        $this->layout='ml';
        $this->render('add');
    }

}