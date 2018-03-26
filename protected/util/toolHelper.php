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
}