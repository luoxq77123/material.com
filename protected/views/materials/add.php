<style>
    a{text-decoration: none;}
    table,table tr, table tr td{border-collapse:collapse;border:1px solid grey; }
    td{height: 40px;}
</style>
<div style="margin: auto;">
<table border="1" cellspacing="0" cellpadding="0" style="margin: auto;">
    <tr align="center">
       <td width="80">材料名称</td>
       <td width="80">日期</td>
       <td width="80">供应商</td>
       <td width="80">送货编号</td>
       <td width="80">入库仓号</td>
       <td width="200">今日入库总量（单位：吨）</td>
       <td width="80">材料员</td>
       <td width="80">备注</td>
    </tr>
    <?php
        $materialName = MaterialsHelper::getMaterialName();

        $materialsUser = MaterialsHelper::getMaterialsUser();
        ?>

        <tr class="" align="center">
            <td>
                <select id="material_name">
                    <option value="0">--请选择--</option>
                    <?php foreach($materialName as $k=>$val){ ?>
                        <option value="<?= $k ?>"><?= $val ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="text" name="add_time" id="add_time" value=""></td>
            <td>
                <select name="su_id" id="su_id">

                </select>
            </td>
            <td><input type="text" name="ml_no" id='ml_no' value=""> </td>
            <td><input type="text" name="ku_nums" id='ku_nums' value=""> </td>
            <td><input type="text" name="num" id='num' value=""> </td>
            <td>
                <select name="user_cl" id="user_cl">
                    <?php foreach ($materialsUser as $m_key=>$materials){ ?>
                        <option value="<?= $m_key ?>"><?= $materials ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="text" name="remarks" id='remarks' value=""> </td>
        </tr>
    <tr>
        <input type="hidden" name="status" id="status" value="0">
        <td colspan="8" align="center" >
            <button><a href="<?= $this->createUrl('materials/index') ?>">返回列表</a></button>&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="button">提交</button>
        </td>
    </tr>

</table>

</div>



<script>

    $('#button').on('click',function(){
        var sta = $("#status").val();

        if(sta !=0 ){
            return false;
        }

        if ($("#material_name").val() == 0) {
            alert("请选择材料");
            return false;
        }

        var datas = [];
        var temp = {};
        temp['ml_id']=$("#material_name").val();
        temp['add_time']=$("#add_time").val();
        temp['su_id']=$("#su_id").val();
        temp['ml_no']=$("#ml_no").val();
        temp['ku_nums']=$("#ku_nums").val();
        temp['num']=$("#num").val();
        temp['user_cl']=$("#user_cl").val();
        temp['remarks']=$("#remarks").val();


        //$("#status").val(1);
        datas.push(temp);
        console.log(datas)
        $.ajax({
            url: "<?= $this->createUrl("/materials/add") ?>",
            type: "post",
            dataType: "json",
            data: {t: datas},
            success: function (result) {
                window.location.href = '<?= $this->createUrl("/materials/index"); ?>';
            }
        })
    });

    /*时间控件开始*/
    laydate.render({
        elem: '#add_time'
    });
    /*时间控件结束*/

    /*下拉列表S*/
    $('#material_name').on('change',function(){
        var type = $("#material_name").val();
        var sta = $("#status").val();
                $.ajax({
                    url: '<?= $this->createUrl("/materials/factory") ?>',
                    type: "post",
                    dataType: "json",
                    data: {type:type},
                    success: function (ret) {
                        var data = ret.data;
                        var optionstring = "";
                        for (var i in data) {
                            var jsonObj =data[i];
                            console.log(jsonObj);
                            optionstring += "<option value='"+i+"' >" + jsonObj + "</option>";
                            $("#su_id").html(optionstring);
                        }
                    },
                    error: function (msg) {
                        alert("出错了！");
                    }
                });
            });

    /*下拉列表e*/
</script>