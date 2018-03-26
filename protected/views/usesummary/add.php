<?php

$materialName = MaterialsHelper::getMaterialName();
$materialGh = MaterialsHelper::getGh();
?>
<style>
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
            <td><input type="text" name="gh_amount" value="100"></td>
            <td><input type="text" name="m_p_water" value="100"></td>
            <td><input type="text" name="m_p_cement" value="100"></td>
            <td><input type="text" name="m_p_ash" value="100"></td>
            <td><input type="text" name="m_p_gravel" value="100"></td>
            <td><input type="text" name="m_p_sand" value="100"></td>
            <td><input type="text" name="m_p_river_sand" value="100"></td>
            <td><input type="text" name="m_p_additive" value="100"></td>
        </tr>

        <?php
    }
    ?>
    <tr align="center">
        <td colspan="9" ><input type="button" id="button" value="提交"></td>
    </tr>
</table>

<script>
    $('#button').on('click',function(){
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
                alert(result);
            }
        })
    });

    /*时间控件开始*/
    laydate.render({
        elem: '#add_time'
    });
    /*时间控件结束*/
</script>