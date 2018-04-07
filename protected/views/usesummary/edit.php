<?php

$add_time = empty($data['add_time']) || empty(strtotime($data['add_time']))?'':date("Y-m-d",strtotime($data['add_time']));
$factoryName = MaterialsHelper::getFactoryName();
$getGh = MaterialsHelper::getGh();
?>


<form action="" method="post">
    <table border="1" method="post">
        <tr>
            <td>日期:</td>
            <td><input type="text" name="add_time" id="add_time" value="<?= $add_time ?>"></td>
        </tr>
        <tr>
            <td>配合比缸号:</td>
            <td><?= $getGh[$data['gh_type']] ?></td>
        </tr>
        <tr>
            <td>生产方量</td>
            <td><input type="text" name="gh_amount" value="<?= $data['gh_amount'] ?>"></td>
        </tr>
        <tr>
            <td>水</td>
            <td><input type="text" name="m_p_water" value="<?= $data['m_p_water'] ?>"></td>
        </tr>
        <?php foreach($factoryName as $key=>$val){
            $name = 'm_p_'.$key;
            ?>
        <tr>
            <td><?= $val[0] ?></td>
            <td><input type="text" name="<?= $name ?>" value="<?= $data[$name] ?>"></td>
        </tr>
        <?php } ?>
        <tr>
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="gh_type" value="<?= $data['gh_type'] ?>">
            <td colspan="2"><input type="submit" value="修改"></td>
        </tr>
    </table>
</form>


<script>
    laydate.render({
        elem: '#add_time'
    });

</script>