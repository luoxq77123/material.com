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
            echo json_encode(['status'=>0]);exit;
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

            //获取时间段内的天数
            $dateArr = toolHelper::getDateFromRange($start,$end);

            //组装数据
            $use_data = UseSummary::dataFormatUse($dateArr,$use_range_data);
            $rep_data = UseSummary::dataFormatRep($dateArr,$rep_range_data);


            $yday_total_cement = (empty($rep_start_data['cement']) ? 0 : $rep_start_data['cement']) - (empty($use_start_data['cement']) ? 0 : $use_start_data['cement']);
            $yday_total_ash = (empty($rep_start_data['ash']) ? 0 : $rep_start_data['ash']) - (empty($use_start_data['ash']) ? 0 : $use_start_data['ash']);
            $yday_total_gravel = (empty($rep_start_data['gravel']) ? 0 : $rep_start_data['gravel']) - (empty($use_start_data['gravel']) ? 0 : $use_start_data['gravel']);
            $yday_total_sand = (empty($rep_start_data['sand']) ? 0 : $rep_start_data['sand']) - (empty($use_start_data['sand']) ? 0 : $use_start_data['sand']);
            $yday_total_river_sand = (empty($rep_start_data['river_sand']) ? 0 : $rep_start_data['river_sand']) - (empty($use_start_data['river_sand']) ? 0 : $use_start_data['river_sand']);
            $yday_total_additive = (empty($rep_start_data['additive']) ? 0 : $rep_start_data['additive']) - (empty($use_start_data['additive']) ? 0 : $use_start_data['additive']);


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

            //循环时间段内的天数
            foreach($dateArr as $val){
                $key = date("YmdHis",strtotime($val));
                $val_gh_data = isset($use_data[$key])?$use_data[$key]:[];
                $val_rep_data = isset($rep_data[$key])?$rep_data[$key]:[];
                //今日入库
                $today_rep_cement = isset($val_rep_data['cement']) ? $val_rep_data['cement'] : 0;
                $today_rep_ash = isset($val_rep_data['ash']) ? $val_rep_data['ash'] : 0;
                $today_rep_gravel = isset($val_rep_data['gravel']) ? $val_rep_data['gravel'] : 0;
                $today_rep_sand = isset($val_rep_data['sand']) ? $val_rep_data['sand'] : 0;
                $today_rep_river_sand = isset($val_rep_data['river_sand']) ? $val_rep_data['river_sand'] : 0;
                $today_rep_additive = isset($val_rep_data['additive']) ? $val_rep_data['additive'] : 0;

                $i++;
                $objectPHPExcel->getActiveSheet()->mergeCells('A' . $i.':I' . $i);
                $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, date("Y年m月d日",strtotime($val)));
               // $objectPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
                $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, $yday_total_cement);
                $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, $yday_total_ash);
                $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, $yday_total_gravel);
                $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, $yday_total_sand);
                $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, $yday_total_river_sand);
                $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, $yday_total_additive);
                $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');

                $i++;
                $objectPHPExcel->getActiveSheet()->mergeCells('A' . $i.':B' . $i);
                $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, '今日入库');
                $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, $today_rep_cement);
                $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, $today_rep_ash);
                $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, $today_rep_gravel);
                $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, $today_rep_sand);
                $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, $today_rep_river_sand);
                $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, $today_rep_additive);
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
                $today_total_cement = $today_total_ash = $today_total_gravel = $today_total_sand = $today_total_river_sand = $today_total_additive = 0;

                //循环当前日期各缸号配比与材料使用量
                foreach($getGh as $key_gh=>$v_gh){

                    $gh_data = isset($val_gh_data[$key_gh]) ? $val_gh_data[$key_gh] : [];

                    $m_p_water = isset($gh_data['m_p_water']) ? $gh_data['m_p_water'] : '';
                    $m_p_cement = isset($gh_data['m_p_cement']) ? $gh_data['m_p_cement'] : '';
                    $m_p_ash = isset($gh_data['m_p_ash']) ? $gh_data['m_p_ash'] : '';
                    $m_p_gravel = isset($gh_data['m_p_gravel']) ? $gh_data['m_p_gravel'] : '';
                    $m_p_sand = isset($gh_data['m_p_sand']) ? $gh_data['m_p_sand'] : '';
                    $m_p_river_sand = isset($gh_data['m_p_river_sand']) ? $gh_data['m_p_river_sand'] : '';
                    $m_p_additive = isset($gh_data['m_p_additive']) ? $gh_data['m_p_additive'] : '';

                    $capacity = isset($gh_data['capacity']) ? $gh_data['capacity'] : '';
                    $gh_amount = isset($gh_data['gh_amount']) ? $gh_data['gh_amount'] : '';

                    $m_u_cement = isset($gh_data['m_u_cement']) ? $gh_data['m_u_cement'] : '';
                    $m_u_ash = isset($gh_data['m_u_ash']) ? $gh_data['m_u_ash'] : '';
                    $m_u_gravel = isset($gh_data['m_u_gravel']) ? $gh_data['m_u_gravel'] : '';
                    $m_u_sand = isset($gh_data['m_u_sand']) ? $gh_data['m_u_sand'] : '';
                    $m_u_river_sand = isset($gh_data['m_u_river_sand']) ? $gh_data['m_u_river_sand'] : '';
                    $m_u_additive = isset($gh_data['m_u_additive']) ? $gh_data['m_u_additive'] : '';

                    //今日总量求和
                    $today_total_cement += $m_u_cement;
                    $today_total_ash += $m_u_ash;
                    $today_total_gravel += $m_u_gravel;
                    $today_total_sand += $m_u_sand;
                    $today_total_river_sand += $m_u_river_sand;
                    $today_total_additive += $m_u_additive;

                    $i++;
                    $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, $v_gh);
                    $objectPHPExcel->getActiveSheet()->setCellValue('B' . $i, $m_p_water);
                    $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, $m_p_cement); //水泥
                    $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, $m_p_ash); //火山灰
                    $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, $m_p_gravel); //碎石
                    $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, $m_p_sand); //机制砂
                    $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, $m_p_river_sand); //河沙
                    $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, $m_p_additive); //外加剂
                    $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, $capacity);
                    $objectPHPExcel->getActiveSheet()->getStyle('A' . $i.':'.'I' . $i)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
                    $objectPHPExcel->getActiveSheet()->getStyle('A' . $i.':'.'I' . $i)->getFill()->getStartColor()->setARGB('FF308E2B');
                    $i++;
                    $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, '今日方量');
                    $objectPHPExcel->getActiveSheet()->setCellValue('B' . $i, $gh_amount);
                    $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, ''); //水泥
                    $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, ''); //火山灰
                    $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, ''); //碎石
                    $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, ''); //机制砂
                    $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, ''); //河沙
                    $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, ''); //外加剂
                    $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');
                    $objectPHPExcel->getActiveSheet()->getStyle('B' . $i)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
                    $objectPHPExcel->getActiveSheet()->getStyle('B' . $i)->getFill()->getStartColor()->setARGB('FFFFC63F');
                    $i++;
                    $objectPHPExcel->getActiveSheet()->setCellValue('A' . $i, '今日用量');
                    $objectPHPExcel->getActiveSheet()->setCellValue('B' . $i, '');
                    $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, $m_u_cement); //水泥
                    $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, $m_u_ash); //火山灰
                    $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, $m_u_gravel); //碎石
                    $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, $m_u_sand); //机制砂
                    $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, $m_u_river_sand); //河沙
                    $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, $m_u_additive); //外加剂
                    $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');

                }

                //今日结余 = 昨日结余+今日入库-今日总用量
                $balance_cement = $yday_total_cement + $today_rep_cement - $today_total_cement;
                $balance_ash = $yday_total_ash + $today_rep_ash - $today_total_ash;
                $balance_gravel = $yday_total_gravel + $today_rep_gravel - $today_total_gravel;
                $balance_sand = $yday_total_sand + $today_rep_sand - $today_total_sand;
                $balance_river_sand = $yday_total_river_sand + $today_rep_river_sand - $today_total_river_sand;
                $balance_additive = $yday_total_additive + $today_rep_additive - $today_total_additive;

                //明日的昨日结余 = 今日结余
                $yday_total_cement = $balance_cement;
                $yday_total_ash = $balance_ash;
                $yday_total_gravel = $balance_gravel;
                $yday_total_sand = $balance_sand;
                $yday_total_river_sand = $balance_river_sand;
                $yday_total_additive = $balance_additive;

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
                $objectPHPExcel->getActiveSheet()->setCellValue('C' . $i, $balance_cement); //水泥
                $objectPHPExcel->getActiveSheet()->setCellValue('D' . $i, $balance_ash); //火山灰
                $objectPHPExcel->getActiveSheet()->setCellValue('E' . $i, $balance_gravel); //碎石
                $objectPHPExcel->getActiveSheet()->setCellValue('F' . $i, $balance_sand); //机制砂
                $objectPHPExcel->getActiveSheet()->setCellValue('G' . $i, $balance_river_sand); //河沙
                $objectPHPExcel->getActiveSheet()->setCellValue('H' . $i, $balance_additive); //外加剂
                $objectPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');
            }
            //设置水平居中
            for($y=1;$y<=$i;$y++){
                $objectPHPExcel->getActiveSheet()->getStyle('A' . $y.':I' . $y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            //设置宽度
            $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $objectPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

            ob_end_clean();
            ob_start();
            header('Content-Type : application/vnd.ms-excel');
            header('Content-Disposition:attachment;filename="' . '材料出库记录-' . date("Y年m月j日") . '.xls"');
            $objWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }



        $this->layout='ml';
        $this->render('export');
    }


}