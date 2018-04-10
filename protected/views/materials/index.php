<style>
    a {
        text-decoration: none;
    }
    table,table tr, table tr td{border-collapse:collapse;border:1px solid grey; }
    td{height:25px;}
</style>

<div style="margin: auto;text-align: center;">
    <div style="margin:auto;height: 20px;padding: 10px 0;width: 75%;text-align: left;">
        <button><a href="<?= $this->createUrl('materials/add') ?>">添加</a></button>
        &nbsp;&nbsp;
        <button><a href="<?= $this->createUrl('index/index') ?>">返回首页</a></button>
    </div>
    <table border="1" cellpadding="0" cellspacing="0" style="margin: auto;">
        <tr align="center">
            <td width="80">材料名称</td>
            <td width="100">日期</td>
            <td width="200">供应商</td>
            <td width="80">送货编号</td>
            <td width="80">入库仓号</td>
            <td width="200">今日入库总量（单位：吨）</td>
            <td width="80">材料员</td>
            <td width="80">备注</td>
            <td width="120">操作</td>
        </tr>
        <?php
        foreach ($data as $val) {
            $factoryName = MaterialsHelper::getFactoryName($val['ml_id']);
            $su_id = isset($factoryName[$val['su_id']]) ? $factoryName[$val['su_id']] : '';
            MaterialsHelper::getMaterialsUser();
            ?>
            <tr align="center">
                <td><?= MaterialsHelper::getMaterialName($val['ml_id']) ?></td>
                <td><?= ToolHelper::timeYmd($val['add_time']) ?></td>
                <td><?= $su_id ?></td>
                <td><?= $val['ml_no'] ?></td>
                <td><?= $val['ku_nums'] ?></td>
                <td><?= $val['num'] / 1000 ?></td>
                <td><?= MaterialsHelper::getMaterialsUser($val['user_cl']) ?></td>
                <td><?= $val['remarks'] ?></td>
                <td>
                    <button style="float: left;margin-left: 10px;">
                        <a href="<?= $this->createUrl('materials/edit', ['id' => $val['id']]) ?>">修改</a>
                    </button>
                    <button class="index_del" data-id="<?= $val['id']; ?>">
                        <span>删除</span>
                    </button>
                </td>
            </tr>
        <?php } ?>
        <tr align="center">
            <td colspan="12">
                <?php
                $this->widget('CLinkPager', array(
                    'header' => '',
                    'prevPageLabel' => '上一页',
                    'nextPageLabel' => '下一页',
                    'pages' => $pages,
                ));
                ?>
            </td>
        </tr>
    </table>
</div>

<script>
    $('.index_del').on('click', function(){
        var id = $(this).data('id');
        if(confirm("确定删除该记录吗?")){
            $.ajax({
                url:"<?= $this->createUrl("/materials/del") ?>",
                type:"POST",
                dataType:"json",
                data:{id:id},
                success: function (result) {
                    if(result.status==0){
                        window.location.reload();
                    }else{
                        layer.open({
                            content: result.msg,
                            skin: 'msg',
                            time: 3 //2秒后自动关闭
                        });
                    }

                }
            })
        }


    })

</script>

