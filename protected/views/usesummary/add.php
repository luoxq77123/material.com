<?php

$materialName = MaterialsHelper::getMaterialName();
$materialGh = MaterialsHelper::getGh();
?>
<style>
    a{text-decoration: none;}
    input{width:70px;}
    table{margin: auto;}
</style>
<table border="0" height="500" >
    <tr align="center">
        <td colspan="9">时间：<input name="add_time" value="" id="add_time"></td>
    </tr>
    <tr align="center">
        <td width="100">配合比缸号</td>
        <td>今日方量</td>
        <td>水</td>
        <?php foreach ($materialName as $val){ ?>
            <td><?= $val ?></td>
        <?php } ?>
    </tr>
    <?php
    foreach ($materialGh as $key=>$val){
        ?>
        <tr align="center">
            <td><input type="hidden" name="gh_type" value="<?= $key?>"> <?= $val ?></td>
            <td><input type="text" name="gh_amount" value=""></td>
            <td><input type="text" name="m_p_water" value=""></td>
            <td><input type="text" name="m_p_cement" value=""></td>
            <td><input type="text" name="m_p_ash" value=""></td>
            <td><input type="text" name="m_p_gravel" value=""></td>
            <td><input type="text" name="m_p_sand" value=""></td>
            <td><input type="text" name="m_p_river_sand" value=""></td>
            <td><input type="text" name="m_p_additive" value=""></td>
        </tr>

        <?php
    }
    ?>
    <tr align="center">
        <input type="hidden" name="status" id="status" value="0">
        <td colspan="9" >
            <button><a href="<?= $this->createUrl('usesummary/index') ?>">返回列表</a></button>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" id="button" value="提交">
        </td>
    </tr>
</table>

<script>
    $('#button').on('click',function(){
        var add_time = $("#add_time").val();
        if(add_time==false){
            alert('请选择时间');
            return false;
        }

        var sta = $("#status").val();
        if(sta !=0 ){
            return false;
        }
        $("#status").val(1);
        var datas = [];
        for(var i = 1 ; i < $('table tr').length - 1;i ++){
            var temp = {};
            for(var j = 0 ; j < $('table tr').eq(i).find('td').length ; j ++){
                var oInput = $('table tr').eq(i).find('input').eq(j);
                (function(obj){
                    temp[obj.attr('name')] = obj.val();
                })(oInput)

            }
            datas.push(temp);
        }

        console.log(datas)
        var add_time = $("#add_time").val();

        $.ajax({
            url:"<?= $this->createUrl("/usesummary/add") ?>",
            type:"POST",
            dataType:"json",
            data:{t:datas,add_time:add_time},
            success: function (result) {
                window.location.href = '<?= $this->createUrl("/usesummary/index"); ?>';
            }
        })
    });

    /*时间控件开始*/
    laydate.render({
        elem: '#add_time'
    });
    /*时间控件结束*/
</script>