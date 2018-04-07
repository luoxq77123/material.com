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
            //var_dump($_POST);exit;
            UseSummary::editRow($_POST);
            $this->redirect(["/usesummary/index"]);exit;
        }

        $data = UseSummary::getDataId($id);
        $this->layout='ml';
        $this->render('edit',['data'=>$data,'id'=>$id]);
    }

    public function actionMexport()
    {
        if(!empty($_POST)){
            $start = Yii::app()->request->getParam('start');
            $end = Yii::app()->request->getParam('end');
            //获取使用量(开始时间之前总使用量)
            $use_start_data = UseSummary::getExportData($start);
            //获取库存量(开始时间之前总库存量)
            $rep_start_data = Materials::getStorageData($start);

            //获取时间段使用量
            $use_range_data = UseSummary::getRangeData($start,$end);
            //获取时间段库存量
            $rep_range_data = Materials::getRangeData($start,$end);
            $dateArr = toolHelper::getDateFromRange($start,$end);

            //循环时间
            foreach($dateArr as $val){
                $str = date("Y年m月d日")."\r";
                $str.="\t\t\t";
            }




            header("Content-type:application/vnd.ms-excel");
            header("Content-Disposition:filename=123.xls");
            $list=[

                [
                                    'id'=>1,
                                    'username'=>1,
                                    'sex'=>1,
                                    'age'=>1,
                                ], [
                    'id'=>1,
                    'username'=>1,
                    'sex'=>1,
                    'age'=>1,
                ],
                [
                                    'id'=>1,
                                    'username'=>1,
                                    'sex'=>1,
                                    'age'=>1,
                                ],
                [
                                    'id'=>1,
                                    'username'=>1,
                                    'sex'=>1,
                                    'age'=>1,
                                ],
            ];




                $strexport = "<tr><td colspan='5'>12312</td></tr>\r";
                $strexport.="编号\t姓名\t性别\t年龄\r";
                foreach ($list as $row){

                    $strexport.=$row['id']."\t";
                    $strexport.=$row['username']."\t";
                    $strexport.=$row['sex']."\t";
                    $strexport.=$row['age']."\r";

                }
                $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport);
                exit($strexport);
exit;
        }
        $this->layout='ml';
        $this->render('export');
    }


}