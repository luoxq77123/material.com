<table border="1">
    <tr>
       <td>材料名称</td>
       <td>日期</td>
       <td>供应商</td>
       <td>送货编号</td>
       <td>入库仓号</td>
       <td>今日入库总量（单位：吨）</td>
       <td>材料员</td>
       <td>备注</td>
    </tr>
    <?php
    $materialName = MaterialsHelper::getMaterialName();
    $id_key=1;
    foreach($materialName as $key=>$val){
        $factoryName = MaterialsHelper::getFactoryName($key);
        $materialsUser = MaterialsHelper::getMaterialsUser();
        ?>

        <tr class="<?= $key ?>">
            <td><input type="hidden" name="ml_id" value="<?= $key ?>" ><?= $val ?></td>
            <td><input type="text" name="add_time" id="add_time<?= $id_key?>" value=""></td>
            <td>
                <select name="su_id" id="su_id<?=$id_key?>">
                    <?php foreach ($factoryName as $f_key=>$factory){ ?>
                        <option value="<?= $f_key ?>"><?= $factory ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="text" name="ml_no" value=""> </td>
            <td><input type="text" name="ku_nums" value=""> </td>
            <td><input type="text" name="num" value=""> </td>
            <td>
                <select name="user_cl" id="user_cl<?=$id_key?>">
                    <?php foreach ($materialsUser as $m_key=>$materials){ ?>
                        <option value="<?= $m_key ?>"><?= $materials ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="text" name="remarks" value=""> </td>
        </tr>

    <?php
        $id_key++;
    } ?>

    <tr>
        <td colspan="8" id="button">提交</td>
    </tr>

</table>

<script>

    $('#button').on('click',function(){
        var datas = [];
    	for(var i = 1 ; i < $('table tr').length - 1;i ++){
            var su_id = $("#su_id"+i).val();
            var user_cl = $("#user_cl"+i).val();
    		var temp = {};
    		for(var j = 0 ; j < $('table tr').eq(i).find('td').length-2 ; j ++){
                var oInput = $('table tr').eq(i).find('input').eq(j);
    			(function(obj){
    				temp[obj.attr('name')] = obj.val();
    			})(oInput)
                temp['su_id']=su_id;
                temp['user_cl']=user_cl;
    		}
    		datas.push(temp);
        }

        //console.log(datas)
        $.ajax({
                    url:"<?= $this->createUrl("/materials/add") ?>",
                    type:"POST",
                    dataType:"json",
                    data:{t:datas},
                    success: function (result) {
                        //alert(result);
                    }
        })
    });

    /*时间控件开始*/
    <?php for ($i=1;$i<7;$i++){  ?>
        laydate.render({
            elem: '#add_time<?= $i ?>'
        });
    <?php } ?>
    /*时间控件结束*/
</script>