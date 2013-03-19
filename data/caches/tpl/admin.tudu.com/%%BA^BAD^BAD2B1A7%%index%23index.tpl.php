<?php /* Smarty version 2.6.26, created on 2013-03-15 13:18:17
         compiled from org/index%23index.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>组织信息</title>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "^style.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery-1.4.4.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery.ajaxupload.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/common.js?1003" type="text/javascript"></script>
<style>
html,body{
    height:100%;
    overflow:hidden;
}
</style>
<script type="text/javascript">
var SITES = {
'static': '<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
',
'tudu': '<?php echo @PROTOCOL; ?>
//<?php echo $this->_tpl_vars['admin']['orgid']; ?>
.tudu.com'
};

var BASE_PATH = '<?php echo $this->_tpl_vars['basepath']; ?>
';
</script>
</head>
<body class="frameset">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "^header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "^nav.tpl", 'smarty_include_vars' => array('tab' => 'org')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="container-main">
    <!-- content-left   -->
    <div class="content-left">
        <ul class="sidebar" id="sidebar">
            <li id="nav-info" class="first current" ><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/org/info/" target="main">基本信息</a></li>
            <li id="nav-logo"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/org/info/logo" target="main">组织LOGO</a></li>
            <?php if ($this->_tpl_vars['admin']['isowner']): ?>
            <li id="nav-pwd"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/org/password/" target="main">修改密码</a></li>
            <?php endif; ?>
            <li id="nav-email"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/org/email/" target="main">密保邮箱</a></li>
        </ul>
    </div>
    <!-- end content-left   -->
    <div class="content-main">
        <?php if (strpos ( $_SERVER['HTTP_USER_AGENT'] , 'MSIE 6' ) === false): ?>
        <iframe height="100%" frameborder="0" scrolling="auto" allowtransparency="true" class="iframe-main" marginheight="0" marginwidth="0" name="main" id="mainframe" src="<?php echo $this->_tpl_vars['basepath']; ?>
/org/info"></iframe>
        <?php else: ?>
        <iframe height="100%" frameborder="0" scrolling="auto" allowtransparency="true" class="iframe-main" marginheight="0" marginwidth="0" name="main" id="mainframe" src="<?php echo $this->_tpl_vars['basepath']; ?>
/org/info"></iframe>
        <?php endif; ?>
    </div>
</div>
<script type="text/javascript">
(function(){
    var s = $('#sidebar').css('overflow', 'auto');
    var t = s.offset().top
    function onResize(){
        var height = document.body.offsetHeight - t;
        $('#sidebar').height(height + 12);
        $('#mainframe').height(height + 12);
    }

    window.onresize = onResize;

    onResize();
})();

$("#sidebar li").click(function(){
    switchMod(this.id.replace('nav-', ''));
});
</script>
</body>
</html>