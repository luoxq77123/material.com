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

            $yesterday_total_cement = $rep_start_data['cement'] - $use_start_data['cement'];
            $yesterday_total_ash = $rep_start_data['ash'] - $use_start_data['ash'];
            $yesterday_total_gravel = $rep_start_data['gravel'] - $use_start_data['gravel'];
            $yesterday_total_sand = $rep_start_data['sand'] - $use_start_data['sand'];
            $yesterday_total_river_sand = $rep_start_data['river_sand'] - $use_start_data['river_sand'];
            $yesterday_total_additive = $rep_start_data['additive'] - $use_start_data['additive'];

            //获取时间段使用量
            $use_range_data = UseSummary::getRangeData($start,$end);
            //获取时间段库存量
            $rep_range_data = Materials::getRangeData($start,$end);



            $dateArr = toolHelper::getDateFromRange($start,$end);


            $use_data = UseSummary::dataFormatUse($dateArr,$use_range_data);
            $rep_data = UseSummary::dataFormatRep($dateArr,$rep_range_data);


            $MaterialName = MaterialsHelper::getMaterialName();
            $getGh = MaterialsHelper::getGh();

            $cement = $MaterialName['cement'];//水泥
            $ash = $MaterialName['ash'];//火山灰
            $gravel = $MaterialName['gravel'];//碎石
            $sand = $MaterialName['sand'];//机制砂
            $river_sand = $MaterialName['river_sand'];//河沙
            $additive = $MaterialName['additive'];//外加剂

            $objectPHPExcel = new PHPExcel();
            $i=0;
            //循环时间
            foreach($dateArr as $val){
                $key = date("YmdHis",strtotime($val));
                $val_gh_data = isset($use_data[$key])?$use_data[$key]:[];
                $val_rep_data = isset($rep_data[$key])?$rep_data[$key]:[];
                $i++;
                $objectPHPExcel->getActiveSheet()->mergeCells('A' . $i.':I' . $i);
                $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, date("Y年m月d日",strtotime($val)));
                $i++;
                $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, '');
                $objectPHPExcel->getActiveSheet()->setCellValue('B' . $i, '');
                $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, $cement);//水泥
                $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, $ash);//火山灰
                $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, $gravel);//碎石
                $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, $sand);//机制砂
                $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, $river_sand);//河沙
                $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, $additive);//外加剂
                $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');
                $i++;
                $objectPHPExcel->getActiveSheet()->mergeCells('A' . $i.':B' . $i);
                $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, '昨日结存');
                $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, $yesterday_total_cement);
                $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, $yesterday_total_ash);
                $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, $yesterday_total_gravel);
                $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, $yesterday_total_sand);
                $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, $yesterday_total_river_sand);
                $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, $yesterday_total_additive);
                $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');

                $i++;
                $objectPHPExcel->getActiveSheet()->mergeCells('A' . $i.':B' . $i);
                $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, '今日入库');
                $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, $val_rep_data['cement']);
                $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, $val_rep_data['ash']);
                $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, $val_rep_data['gravel']);
                $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, $val_rep_data['sand']);
                $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, $val_rep_data['river_sand']);
                $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, $val_rep_data['additive']);
                $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');
                $i++;

                $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, '配合比缸号');
                $objectPHPExcel->getActiveSheet()->setCellValue('B' . $i, '水');
                $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, $cement); //水泥
                $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, $ash); //火山灰
                $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, $gravel); //碎石
                $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, $sand); //机制砂
                $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, $river_sand); //河沙
                $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, $additive); //外加剂
                $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, '容量');

                //今日总用量
                $today_total_cement = 0;
                $today_total_ash = 0;
                $today_total_gravel = 0;
                $today_total_sand = 0;
                $today_total_river_sand = 0;
                $today_total_additive = 0;


                foreach($getGh as $key_gh=>$v_gh){
                    $i++;
                    $gh_data = $val_gh_data[$key_gh];
                    $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, $v_gh);
                    $objectPHPExcel->getActiveSheet()->setCellValue('B' . $i, $gh_data['m_p_water']);
                    $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, $gh_data['m_p_cement']); //水泥
                    $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, $gh_data['m_p_ash']); //火山灰
                    $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, $gh_data['m_p_gravel']); //碎石
                    $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, $gh_data['m_p_sand']); //机制砂
                    $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, $gh_data['m_p_river_sand']); //河沙
                    $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, $gh_data['m_p_additive']); //外加剂
                    $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, $gh_data['capacity']);
                    $i++;
                    $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, '今日方量');
                    $objectPHPExcel->getActiveSheet()->setCellValue('B' . $i, $gh_data['gh_amount']);
                    $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, ''); //水泥
                    $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, ''); //火山灰
                    $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, ''); //碎石
                    $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, ''); //机制砂
                    $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, ''); //河沙
                    $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, ''); //外加剂
                    $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');
                    $i++;
                    $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, '今日用量');
                    $objectPHPExcel->getActiveSheet()->setCellValue('B' . $i, '');
                    $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, $gh_data['m_u_cement']); //水泥
                    $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, $gh_data['m_u_ash']); //火山灰
                    $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, $gh_data['m_u_gravel']); //碎石
                    $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, $gh_data['m_u_sand']); //机制砂
                    $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, $gh_data['m_u_river_sand']); //河沙
                    $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, $gh_data['m_u_additive']); //外加剂
                    $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');

                    $today_total_cement += $gh_data['m_u_cement'];
                    $today_total_ash += $gh_data['m_u_ash'];
                    $today_total_gravel += $gh_data['m_u_gravel'];
                    $today_total_sand += $gh_data['m_u_sand'];
                    $today_total_river_sand += $gh_data['m_u_river_sand'];
                    $today_total_additive += $gh_data['m_u_additive'];
                }

                $i++;
                $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, '今日总用量');
                $objectPHPExcel->getActiveSheet()->setCellValue('B' . $i, '');
                $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, $today_total_cement); //水泥
                $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, $today_total_ash); //火山灰
                $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, $today_total_gravel); //碎石
                $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, $today_total_sand); //机制砂
                $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, $today_total_river_sand); //河沙
                $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, $today_total_additive); //外加剂
                $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');
                $i++;
                $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, '今日结余');
                $objectPHPExcel->getActiveSheet()->setCellValue('B' . $i, '');
                $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, ''); //水泥
                $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, ''); //火山灰
                $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, ''); //碎石
                $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, ''); //机制砂
                $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, ''); //河沙
                $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, ''); //外加剂
                $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');
            }




                   //数据遍历

                   ob_end_clean();
                   ob_start();
                   header('Content-Type : application/vnd.ms-excel');
                   header('Content-Disposition:attachment;filename="' . '会员系统数据-' . date("Y年m月j日") . '.xls"');
                   $objWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
                   $objWriter->save('php://output');

                   exit;





        }



        $this->layout='ml';
        $this->render('export');
    }


}