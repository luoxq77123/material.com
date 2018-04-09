<style>
    a{margin:auto;text-decoration: none;}
</style>

<div style="width: 80%;margin: auto;margin-top: 20%">
    <div style="margin: auto;width: 60%;">
    <form method="post" >
        <div style="margin: auto; text-align: center;">
            导出时间： <input type="text" name="start" id="start" > -- <input type="text" name="end" id="end">
        </div>

        <div style=" width: 200px; margin: auto;margin-top: 50px;">
            <button><a href="<?= $this->createUrl('index/index') ?>">返回首页</a></button>
            <input type="submit" value="导出">
        </div>

    </form>
    </div>
</div>

<script>
    laydate.render({
        elem: '#start'
    });
    laydate.render({
        elem: '#end'
    });
</script>