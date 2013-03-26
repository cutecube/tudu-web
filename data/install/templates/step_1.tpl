<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图度安装向导</title>
<style type="text/css">
.red{
    color:#c00;
}
</style>
<script src="/js/jquery-1.4.4.js" type="text/javascript"></script>
</head>
<body>
    <div id="header">安装环境检查</div>
    <div id="main">
        <div style="margin-top:50px;">忽略</div>
        <form method="get" autocomplete="off" action="?" style="margin-top:123px;">
        <input type="hidden" name="step" value="{$step}">
        <button id="back">上一步</button>&nbsp;
        <button type="submit">下一步</button>
        </form>
    </div>
    <div id="footer">Copyright &copy;2013 <a href="http://www.tudu.com/">tudu.com</a></div>
</body>
<script type="text/javascript">
<!--
$(function(){
    $('#back').click(function() {
        window.history.go(-1);
        return false;
    });
});
-->
</script>
</html>