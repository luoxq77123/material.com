<?php
class ResponseHelper
{
    public static function backFormat($status=0,$data=[],$msg='ok')
    {
        if($status){
            $code = [
                '10100'=>'参数错误',
                '40001'=>'添加失败',
                '40002'=>'修改失败',
                '40003'=>'删除失败',
            ];
            $msg = isset($code[$status])?$code[$status]:'no';
        }

        $arr = [
            'status'=>$status,
            'data'=>$data,
            'msg'=>$msg,
        ];

        echo json_encode($arr);exit;
    }
}