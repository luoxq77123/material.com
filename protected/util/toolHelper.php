<?php
class toolHelper
{
    /**
     * 时间格式化（YYYY-mm-dd）
     */
    public static function timeYmd($time)
    {
        if(empty($time)){
            return '';
        }
        return date("Y-m-d",strtotime($time));
    }

    //计算时间段内的天数
    public static function getDateFromRange($startdate, $enddate){

        $stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);

        // 计算日期段内有多少天
        $days = ($etimestamp-$stimestamp)/86400+1;

        // 保存每天日期
        $date = array();

        for($i=0; $i<$days; $i++){
            $date[] = date('Y-m-d 00:00:00', $stimestamp+(86400*$i));
        }

        return $date;
    }

    public static function createtable($list,$filename,$header=array(),$index = array()){
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:filename=".$filename.".xls");
        $teble_header = implode("\t",$header);
        $strexport = $teble_header."\r";
        foreach ($list as $row){
            foreach($index as $val){
                $strexport.=$row[$val]."\t";
            }
            $strexport.="\r";

        }
        $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport);
        exit($strexport);
    }


}