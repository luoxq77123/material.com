<?php
    $ml_id = empty($data['ml_id'])?'':MaterialsHelper::getMaterialName($data['ml_id']);
    $add_time = empty($data['add_time']) || empty(strtotime($data['add_time']))?'':date("Y-m-d",strtotime($data['add_time']));
    $su_id = empty($data['su_id'])?'':$data['su_id'];
    $ml_no = empty($data['ml_no'])?'':$data['ml_no'];
    $ku_nums = empty($data['ku_nums'])?'':$data['ku_nums'];
    $num = empty($data['num'])?'':$data['num']/1000;
    $user_cl = empty($data['user_cl'])?'':$data['user_cl'];
    $remarks = empty($data['remarks'])?'':$data['remarks'];

    $factoryName = MaterialsHelper::getFactoryName($data['ml_id']);
    $materialsUser = MaterialsHelper::getMaterialsUser();
?>


<form action="" method="post">
    <table border="1">
        <tr>
            <td>材料名称:</td>
            <td><?= $ml_id ?></td>
        </tr>
        <tr>
            <td>日期:</td>
            <td><input type="text" name="add_time" id="add_time" value="<?= $add_time ?>"></td>
        </tr>
        <tr>
            <td>供应商</td>
            <td>
                <select name="su_id">
                    <?php foreach ($factoryName as $f_key=>$factory){ ?>
                        <option value="<?= $f_key ?>" <?= $su_id==$f_key?'selected':'' ?> ><?= $factory ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>送货编号</td>
            <td><input type="text" name="ml_no" value="<?= $ml_no ?>"></td>
        </tr>
        <tr>
            <td>入库仓号</td>
            <td><input type="text" name="ku_nums" value="<?= $ku_nums ?>"></td>
        </tr>
        <tr>
            <td>今日入库总量（单位：吨）</td>
            <td><input type="text" name="num" value="<?= $num ?>"></td>
        </tr>
        <tr>
            <td>材料员</td>
            <td>
                <select name="user_cl">
                    <?php foreach ($materialsUser as $m_key=>$materials){ ?>
                        <option value="<?= $m_key ?>" <?= $user_cl==$m_key ?'selected':'' ?>><?= $materials ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>备注</td>
            <td><input type="text" name="remarks" value="<?= $remarks ?>"></td>
        </tr>
        <tr>
            <input type="hidden" name="id" value="<?= $id ?>">
            <td colspan="2"><input type="submit" value="修改"></td>
        </tr>
    </table>
</form>


<script>
    laydate.render({
        elem: '#add_time'
    });

</script>