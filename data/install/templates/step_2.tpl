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
    <div id="header">图度安装向导</div>
    <div id="main">
        <form id="theform" method="post" action="/install.php" style="margin:10px;">
        <div style="margin:5px;"><strong>1、填写数据库(MySQL)信息</strong></div>
        <div style="margin-left:15px;">
        <table>
            <tr>
                <th width="150" align="left">数据库服务器:</th>
                <td width="200"><input name="dbinfo[host]" value="{$mysql.host}" type="text" size="25" /></td>
                <td>数据库服务器地址, 一般为 localhost</td>
            </tr>
            <tr>
                <th width="150" align="left">数据库端口号:</th>
                <td width="200"><input name="dbinfo[port]" value="{$mysql.port}" type="text" size="25" /></td>
                <td>数据库端口号, 一般为 3306</td>
            </tr>
            <tr>
                <th width="150" align="left">数据库名:</th>
                <td width="200"><input name="dbinfo[database]" value="{$mysql.database}" type="text" size="25" /></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th width="150" align="left">数据库用户名:</th>
                <td width="200"><input name="dbinfo[user]" value="{$mysql.user}" type="text" size="25" /></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th width="150" align="left">数据库密码:</th>
                <td width="200"><input name="dbinfo[password]" value="{$mysql.password}" type="text" size="25" /></td>
                <td>&nbsp;</td>
            </tr>
        </table>
        </div>
        <div style="margin:5px;"><strong>2、填写HTTPSQS信息</strong></div>
        <div style="margin-left:15px;">
        <table>
            <tr>
                <th width="150" align="left">服务器地址:</th>
                <td width="200"><input name="httpsqs[host]" value="{$httpsqs.host}" type="text" size="25" /></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th width="150" align="left">服务器端口号:</th>
                <td width="200"><input name="httpsqs[port]" value="{$httpsqs.port}" type="text" size="25" /></td>
                <td>&nbsp;</td>
            </tr>
        </table>
        </div>
        <div style="margin:5px;"><strong>3、填写Memcache信息</strong></div>
        <div style="margin-left:15px;">
        <table>
            <tr>
                <th width="150" align="left">服务器地址:</th>
                <td width="200"><input name="memcache[host]" value="{$memcache.host}" type="text" size="25" /></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th width="150" align="left">服务器端口号:</th>
                <td width="200"><input name="memcache[port]" value="{$memcache.port}" type="text" size="25" /></td>
                <td>&nbsp;</td>
            </tr>
        </table>
        </div>
        <div style="margin:5px;"><strong>4、填写图度办公系统信息</strong></div>
        <div style="margin-left:15px;">
        <table>
            <tr>
                <th width="150" align="left">组织ID:</th>
                <td width="200"><input name="tudu[orgid]" value="" type="text" size="25" /></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th width="150" align="left">组织名称:</th>
                <td width="200"><input name="tudu[orgname]" value="" type="text" size="25" /></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th width="150" align="left">管理员账号:</th>
                <td width="200"><input name="tudu[userid]" value="admin" type="text" size="25" /></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th width="150" align="left">管理员密码:</th>
                <td width="200"><input name="tudu[password]" value="" type="password" size="25" /></td>
                <td>管理员密码不能为空</td>
            </tr>
            <tr>
                <th width="150" align="left">重复密码:</th>
                <td width="200"><input name="tudu[password2]" value="" type="password" size="25" /></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th width="150" align="left">管理员Email:</th>
                <td width="200"><input name="tudu[email]" value="" type="text" size="25" /></td>
                <td>&nbsp;</td>
            </tr>
        </table>
        </div>
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

    var form = $('#theform');
    form.submit(function(){return false;});
    form.submit(function(){
        if (!$('input[name="dbinfo[host]"]').val().replace(/^\s+|\s+$/, '')) {
            alert('请输入数据库服务器地址');
            return false;
        }
        if (!$('input[name="dbinfo[port]"]').val().replace(/^\s+|\s+$/, '')) {
            alert('请输入数据库服务器端口号');
            return false;
        }
        if (!$('input[name="dbinfo[database]"]').val().replace(/^\s+|\s+$/, '')) {
            alert('请输入数据库名');
            return false;
        }
        if (!$('input[name="dbinfo[user]"]').val().replace(/^\s+|\s+$/, '')) {
            alert('请输入数据库用户名');
            return false;
        }
        if (!$('input[name="httpsqs[host]"]').val().replace(/^\s+|\s+$/, '')) {
            alert('请输入HttpSQS服务器地址');
            return false;
        }
        if (!$('input[name="httpsqs[port]"]').val().replace(/^\s+|\s+$/, '')) {
            alert('请输入HttpSQS服务器端口号');
            return false;
        }
        if (!$('input[name="memcache[host]"]').val().replace(/^\s+|\s+$/, '')) {
            alert('请输入Memcache服务器地址');
            return false;
        }
        if (!$('input[name="memcache[port]"]').val().replace(/^\s+|\s+$/, '')) {
            alert('请输入Memcache服务器端口号');
            return false;
        }
        if (!$('input[name="tudu[orgid]"]').val().replace(/^\s+|\s+$/, '')) {
            alert('请输入组织ID');
            return false;
        }
        if (!$('input[name="tudu[orgname]"]').val().replace(/^\s+|\s+$/, '')) {
            alert('请输入组织名称');
            return false;
        }
        if (!$('input[name="tudu[userid]"]').val().replace(/^\s+|\s+$/, '')) {
            alert('请输入管理员账号');
            return false;
        }
        if (!$('input[name="tudu[password]"]').val().replace(/^\s+|\s+$/, '')) {
            alert('请输入管理员密码');
            return false;
        }
        if ($('input[name="tudu[password]"]').val() != $('input[name="tudu[password2]"]').val()) {
            alert('两次输入的密码不一致');
            return false;
        }

        var data = form.serializeArray();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: data,
            url: form.attr('action'),
            success: function(ret) {
                if (!ret.success) {
                    alert(ret.message);
                } else {
                    location = ret.data.url;
                }
            },
            error: function(res) {}
        });
    });
});
-->
</script>
</html>