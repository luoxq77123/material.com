<form method="post">
   导出开始时间： <input type="text" name="start" id="start" >
   导出结束时间： <input type="text" name="end" id="end">
    <input type="submit" value="导出">
</form>

<script>
    laydate.render({
        elem: '#start'
    });
    laydate.render({
        elem: '#end'
    });
</script>