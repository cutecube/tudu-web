<?php /* Smarty version 2.6.26, created on 2013-03-15 13:18:44
         compiled from settings/dilation%23index.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($this->_tpl_vars['status'] == 2): ?>
<title>容量扩展 - 第二步 扩展方法</title>
<?php else: ?>
<title>容量扩展 - 第一步 实名认证</title>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "^style.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/frame.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['www']; ?>
/js/ui/base.js?1001" type="text/javascript"></script>
<?php if ($this->_tpl_vars['status'] == 2): ?>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/dilation.js" type="text/javascript"></script>
<?php endif; ?>
</head>
<body>
<div class="dilation">
    <div class="title-bar">
        <strong class="f14 text-title">容量扩展</strong>
    </div>
    <?php if ($this->_tpl_vars['status'] == 2): ?>
    <div class="stepbar">
        <div class="step current-2">
            <div class="step-1"><span>1.实名认证</span></div>
            <div class="step-mid"><span>&nbsp;</span></div>
            <div class="step-2"><span>2.扩容方法</span></div>
        </div>
    </div>
    <div class="content">
        <div class="method-box" style="padding-top:15px;height:120px;">
            <div class="method-title"><strong>方法一：微博分享</strong></div>
            <p style="font-size:12px"><span class="gray">将微博信息分享给好友后，</span><strong class="red">立即增加2G空间！</strong></p>
            <table class="table-form" cellspacing="0" cellpadding="5" border="0">
                <tr>
                    <td align="right">微博昵称：</td>
                    <td><input class="text-big" autocomplete="off" type="text" size="45" style="width:360px;" id="nickname" value=""<?php if ($this->_tpl_vars['status'] != 2): ?> disabled="disabled"<?php endif; ?> /><span style="color:#ec6e0a;margin-left:5px;">*</span></td>
                </tr>
                <tr>
                    <td width="70"></td>
                    <td><input type="image" src="<?php echo $this->_tpl_vars['basepath']; ?>
/img/weibo_share.gif" id="weiboshare"<?php if ($this->_tpl_vars['status'] != 2 || $this->_tpl_vars['weiboquota']): ?> disabled="disabled"<?php endif; ?><?php if ($this->_tpl_vars['weiboquota']): ?> title="您已经使用本方法扩容过了"<?php endif; ?> /></td>
                </tr>
            </table>
        </div>
        <div class="method-box">
            <div class="method-title"><strong>方法二：绑定手机</strong></div>
            <p style="font-size:12px"><span class="gray">完善手机资料后，</span><strong class="red">立即增加2G空间！</strong></p>
            <table class="table-form" cellspacing="0" cellpadding="5" border="0">
                <tr>
                    <td width="70" align="right">手机号：</td>
                    <td><input class="text-big" autocomplete="off" type="text" size="45" style="width:230px;" id="mobile"<?php if ($this->_tpl_vars['status'] != 2): ?> disabled="disabled"<?php endif; ?><?php if ($this->_tpl_vars['status'] == 2): ?> value="<?php echo $this->_tpl_vars['bind']['mobile']; ?>
"<?php endif; ?> />&nbsp;<input id="sendcode" class="btn-big" type="button" value="获取验证码" style="width:125px;margin-top: 0;"<?php if ($this->_tpl_vars['status'] != 2): ?> disabled="disabled"<?php endif; ?> /></td>
                </tr>
                <tr>
                    <td align="right">验证码：</td>
                    <td><input class="text-big" autocomplete="off" type="text" size="45" style="width:360px;" id="seccode"<?php if ($this->_tpl_vars['status'] != 2): ?> disabled="disabled"<?php endif; ?> /><span style="color:#ec6e0a;margin-left:5px;">*</span></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input id="valid-phone" class="btn-big" type="button" value="绑定手机" style="margin-top: 0;"<?php if ($this->_tpl_vars['status'] != 2): ?> disabled="disabled"<?php endif; ?> /></td>
                </tr>
            </table>
        </div>
        <div class="method-box" style="border-bottom: 0px;height:120px;">
            <div class="method-title"><strong>方法三：图度数增长量</strong></div>
            <p style="font-size:12px"><span class="gray">图度发送量增长到</span><span class="red">888</span><span class="gray">后，</span><strong class="red">可增加4G空间！</strong></p>
            <p><span class="gray">您的图度数已达到：</span><strong><?php echo $this->_tpl_vars['count']; ?>
</strong></p>
            <table class="table-form" cellspacing="0" cellpadding="5" border="0">
                <tr>
                    <td width="70">&nbsp;</td>
                    <td><input id="valid-tudu" class="btn-big" type="button" value="增加容量" style="margin-top: 0;"<?php if ($this->_tpl_vars['status'] != 2 || $this->_tpl_vars['count'] < 888): ?> disabled="disabled"<?php endif; ?> /></td>
                </tr>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="stepbar">
        <div class="step current-1">
            <div class="step-1"><span>1.实名认证</span></div>
            <div class="step-mid"><span>&nbsp;</span></div>
            <div class="step-2"><span>2.扩容方法</span></div>
        </div>
    </div>
    <div class="content" style="padding:10px 0;">
        <p class="gray">增加用户使用的安全性，企业实名认证后，</p>
        <p class="red"><strong>可获得500用户数、空间将扩展到2G！</strong></p>
        <input class="btn-big" type="button" value="实名认证" onclick="top.location='<?php echo $this->_tpl_vars['basepath']; ?>
/org/#<?php echo $this->_tpl_vars['basepath']; ?>
/org/real'" />
    </div>
    <?php endif; ?>
</div>
</body>
<script type="text/javascript">
<!--
$(function() {
    _TOP.switchMod('dilation');
    <?php if ($this->_tpl_vars['status'] == 2): ?>
    Dilation.init();
    <?php endif; ?>
});
-->
</script>
</html>