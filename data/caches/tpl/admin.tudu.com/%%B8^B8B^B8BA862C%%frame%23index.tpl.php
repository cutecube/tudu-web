<?php /* Smarty version 2.6.26, created on 2013-03-15 11:44:02
         compiled from default/frame%23index.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图度后台</title>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "^style.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/Jcrop/css/jquery.Jcrop.css" type="text/css" rel="stylesheet"/>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery-1.4.4.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery.Jcrop.min.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery.ajaxupload.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery.tree.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/common.js?1003" type="text/javascript"></script>
<script type="text/javascript">
<!--
var BASE_PATH = '<?php echo $this->_tpl_vars['basepath']; ?>
';
var SITES = {
'static': '<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
',
'tudu': '<?php echo @PROTOCOL; ?>
//<?php echo $this->_tpl_vars['admin']['orgid']; ?>
.tudu.com'
};
-->
</script>
<style>
html,body{
    height:100%;
    overflow:hidden;
}
</style>
</head>
<body class="frameset">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "^header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "^nav.tpl", 'smarty_include_vars' => array('tab' => 'sys')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="container-main">
    <!-- content-left   -->
    <div class="content-left">
        <ul class="sidebar" id="sidebar">
            <li id="nav-user" class="first"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/user/user/" target="main">帐号</a></li>
            <li id="nav-dept"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/user/department/" target="main">组织架构</a></li>
            <li id="nav-role"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/user/role/" target="main">权限</a></li>
            <li id="nav-group"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/user/group/" target="main">群组</a></li>
            <li id="nav-board"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/board/board/" target="main">分区管理</a></li>
            <li id="nav-setting"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/settings/general" target="main">基本设置</a></li>
            <li id="nav-secure"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/secure/" target="main">系统安全</a></li>
                    </ul>
    </div>
    <!-- end content-left   -->
    <div class="content-main">
        <iframe height="100%" frameborder="0" scrolling="auto" allowtransparency="true" class="iframe-main" marginheight="0" marginwidth="0" name="main" id="mainframe" src="<?php echo $this->_tpl_vars['basepath']; ?>
/user/user/"></iframe>
    </div>

</div>
<script type="text/javascript">


(function(){

	var s = $('#sidebar').css('overflow', 'auto');
    var t = s.offset().top
    function onResize(){
        var height = document.body.offsetHeight - t;
        $('#sidebar').height(height);
        $('#mainframe').height(height);
    }

    window.onresize = onResize;

    onResize();

})()

$("#sidebar li").click(function(){
	switchMod(this.id.replace('nav-', ''));
});

</script>
</body>
</html>