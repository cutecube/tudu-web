<?php /* Smarty version 2.6.26, created on 2013-03-15 11:34:57
         compiled from default/index%23index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'default/index#index.tpl', 32, false),array('modifier', 'rand', 'default/index#index.tpl', 41, false),array('modifier', 'format_file_size', 'default/index#index.tpl', 54, false),)), $this); ?>
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
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/ie6-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.png, background,img');
</script>
<![endif]-->
<script type="text/javascript">
if (top != self) {
	top.location = self.location.href;
}
</script>
</head>
<body style="padding:0;margin:0">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "^header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "^nav.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="container-main">
    <div class="home">
        <div class="home-right">
            <div class="user-info-wrap">
                <div class="user-info">
                    <div class="info-item">
                        <div class="info-title"><span>组织名称</span></div>
                        <p class="user-name">
                        <a href="<?php echo $this->_tpl_vars['basepath']; ?>
/org/#<?php echo $this->_tpl_vars['basepath']; ?>
/org/info/">
                        <?php if ($this->_tpl_vars['org']['orgname']): ?>
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['org']['orgname'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

                        <?php else: ?>+添加组织名称
                        <?php endif; ?>
                        </a>
                                                </p>
                    </div>
                    <div class="info-item user-logo">
                        <div class="info-title"><span>组织LOGO</span></div>
                        <p><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/org/#<?php echo $this->_tpl_vars['basepath']; ?>
/org/info/logo"><img src="<?php echo $this->_tpl_vars['options']['sites']['www']; ?>
/logo/?oid=<?php echo $this->_tpl_vars['org']['orgid']; ?>
&t=1&r=<?php echo ((is_array($_tmp=0)) ? $this->_run_mod_handler('rand', true, $_tmp, 9999) : rand($_tmp, 9999)); ?>
" border="0"></a></p>
                    </div>
                    <div class="info-item">
                        <div class="info-title"><span>登录地址</span></div>
                        <p class="user-url"><?php echo $this->_tpl_vars['org']['orgid']; ?>
.tudu.com</p>
                    </div>
                    <div class="info-item user-data">
                        <div class="info-title"><span>系统信息</span></div>
                        <table class="user-data" border="0" cellspacing="0" cellpadding="5" width="335" align="center">
                            <tr>
                                <td align="left" style="line-height:17px">
                                    <div class="user-data-chart" style="margin-right:5px;"><div id="quotachart"></div></div>
                                    <p class="user-data-name">系统空间</p>
                                    <p>总空间：<?php echo ((is_array($_tmp=$this->_tpl_vars['org']['maxquota'])) ? $this->_run_mod_handler('format_file_size', true, $_tmp, 1000) : $this->_plugins['modifier']['format_file_size'][0][0]->formatFileSize($_tmp, 1000)); ?>
</p>
                                    <p>已使用：<?php echo ((is_array($_tmp=$this->_tpl_vars['usedquota'])) ? $this->_run_mod_handler('format_file_size', true, $_tmp, 1024, 1) : $this->_plugins['modifier']['format_file_size'][0][0]->formatFileSize($_tmp, 1024, 1)); ?>
</p>
                                </td>
                                <td align="left" style="line-height:17px">
                                    <div class="user-data-chart" style="margin-right:5px;"><div id="ndchart"></div></div>
                                    <p class="user-data-name">网盘空间</p>
                                    <p>总空间：<?php echo ((is_array($_tmp=$this->_tpl_vars['org']['maxndquota'])) ? $this->_run_mod_handler('format_file_size', true, $_tmp, 1000) : $this->_plugins['modifier']['format_file_size'][0][0]->formatFileSize($_tmp, 1000)); ?>
</p>
                                    <p>已使用：<?php echo ((is_array($_tmp=$this->_tpl_vars['usendquota'])) ? $this->_run_mod_handler('format_file_size', true, $_tmp, 1000, 1) : $this->_plugins['modifier']['format_file_size'][0][0]->formatFileSize($_tmp, 1000, 1)); ?>
</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="home-left">
            <div class="home-pic" style="cursor:pointer" onclick="location='<?php echo $this->_tpl_vars['basepath']; ?>
/frame/#<?php echo $this->_tpl_vars['basepath']; ?>
/settings/dilation/'"><div class="home-pic-inner"></div></div>
            <div class="functional-block">
                <table border="0" cellspacing="10" cellpadding="0" width="100%">
                    <tr>
                        <td><div class="functional-accounts"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/frame/#<?php echo $this->_tpl_vars['basepath']; ?>
/user/user/" class="png"><p class="functional-title">帐号</p><span style="line-height:20px">帐号数：共<?php echo $this->_tpl_vars['org']['maxusers']; ?>
个<br>已开通<?php echo $this->_tpl_vars['count']['user']; ?>
个帐号</span></a></div></td>
                        <td><div class="functional-structure"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/frame/#<?php echo $this->_tpl_vars['basepath']; ?>
/user/department/" class="png"><p class="functional-title">组织架构</p><span style="line-height:20px">已建部门数：共<?php echo $this->_tpl_vars['count']['dept']; ?>
个</span></a></div></td>
                        <td><div class="functional-permissions"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/frame/#<?php echo $this->_tpl_vars['basepath']; ?>
/user/role/" class="png"><p class="functional-title">权限</p><span style="line-height:20px">已建权限组：共<?php echo $this->_tpl_vars['count']['role']; ?>
个</span></a></div></td>
                    </tr>
                    <tr>
                        <td><div class="functional-group"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/frame/#<?php echo $this->_tpl_vars['basepath']; ?>
/user/group/" class="png"><p class="functional-title">群组</p><span style="line-height:20px">已建群组：共<?php echo $this->_tpl_vars['count']['group']; ?>
个</span></a></div></td>
                        <td><div class="functional-board"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/frame/#<?php echo $this->_tpl_vars['basepath']; ?>
/board/board/" class="png"><p class="functional-title">分区管理</p><span style="line-height:20px">已建分区：共<?php echo $this->_tpl_vars['count']['board']; ?>
个</span></a></div></td>
                        <td><div class="functional-safety"><a href="<?php echo $this->_tpl_vars['basepath']; ?>
/frame/#<?php echo $this->_tpl_vars['basepath']; ?>
/secure/index/" class="png"><p class="functional-title">系统安全</p><span style="line-height:20px">安全等级：<?php if ($this->_tpl_vars['secure'] >= 80): ?>高<?php elseif ($this->_tpl_vars['secure'] >= 55): ?>中<?php else: ?>低<?php endif; ?></span></a></div></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <a href="<?php echo $this->_tpl_vars['options']['sites']['www']; ?>
/about/about.html" target="_blank">关于我们</a> |
    <a href="<?php echo $this->_tpl_vars['options']['sites']['www']; ?>
/about/contact.html" target="_blank">联系我们</a> |
        <a href="<?php echo $this->_tpl_vars['options']['sites']['www']; ?>
/about/privacy.html" target="_blank">隐私保护</a> |
    <a href="<?php echo $this->_tpl_vars['options']['sites']['www']; ?>
/about/copyright.html" target="_blank">版权声明</a> |
    <a href="<?php echo $this->_tpl_vars['options']['sites']['www']; ?>
/help/index.html" target="_blank">相关帮助</a>
    <p>Copyright © 2012 tudu.com</p>
</div>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery-1.4.4.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery.charts-min.js" type="text/javascript"></script>
<?php if ($this->_tpl_vars['guidetips']): ?>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/guide.js" type="text/javascript"></script>
<?php endif; ?>
<script type="text/javascript">
<!--
var ndChart = new Highcharts.Chart({
    colors: ['#cfcfcf', '#62b3c4'],
    chart: {
        renderTo: 'ndchart',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        width: 56,
        height:56,
        margin: [0,0,0,0]
    },
    series: [{
        type: 'pie',
        name: '',
        data: [
            ['used', <?php echo $this->_tpl_vars['usendquota']; ?>
],
            ['free', <?php echo $this->_tpl_vars['org']['maxndquota']; ?>
-<?php echo $this->_tpl_vars['usendquota']; ?>
]
        ]
    }]
});

var quotaChart = new Highcharts.Chart({
    colors: ['#cfcfcf', '#62b3c4'],
    chart: {
        renderTo: 'quotachart',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        width: 56,
        height:56,
        margin: [0,0,0,0]
    },
    series: [{
        type: 'pie',
        name: '',
        data: [
            ['used', <?php echo $this->_tpl_vars['usedquota']; ?>
],
            ['free', <?php echo $this->_tpl_vars['org']['maxquota']; ?>
-<?php echo $this->_tpl_vars['usedquota']; ?>
]
        ]
    }]
});
<?php if ($this->_tpl_vars['guidetips']): ?>
var BASE_PATH = '<?php echo $this->_tpl_vars['basepath']; ?>
';
Guide.init();
<?php endif; ?>
-->
</script>
</body>
</html>