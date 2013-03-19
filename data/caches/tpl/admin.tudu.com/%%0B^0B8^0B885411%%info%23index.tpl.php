<?php /* Smarty version 2.6.26, created on 2013-03-15 12:01:01
         compiled from org/info%23index.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>基本信息</title>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "^style.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery-1.4.4.js" type="text/javascript"></script>
</head>
<body>
<div class="title-bar"><strong class="f14">基本信息</strong></div>
<div class="msgbox" style="margin-top:8px;">
    <p>注：以下“<span style="color:#ec6e0a;margin-left:5px;">*</span>”项，为&nbsp;<strong>企业实名认证</strong>&nbsp;时的必填项。</p>
</div>
<form id="infoform" action="<?php echo $this->_tpl_vars['basepath']; ?>
/org/info/save" method="post" class="form-separate">
<input type="hidden" name="action" value="<?php echo $this->_tpl_vars['action']; ?>
" />
<input type="hidden" id="ids-val" value="<?php echo $this->_tpl_vars['info']['industry']; ?>
" />
<input type="hidden" id="province-val" value="<?php echo $this->_tpl_vars['info']['province']; ?>
" />
<input type="hidden" id="city-val" value="<?php echo $this->_tpl_vars['info']['city']; ?>
" />
<?php if ($this->_tpl_vars['info']['realnamestatus'] == 2): ?>
<input type="hidden" name="entirename" value="<?php echo $this->_tpl_vars['info']['entirename']; ?>
" />
<?php endif; ?>
    <fieldset class="form-field first" style="border-top:0;">
        <table border="0" cellspacing="0" cellpadding="5" class="table-form">
            <tr>
                <th align="right" width="90">组织全称：</th>
                <td><input class="text-big" value="<?php echo $this->_tpl_vars['info']['entirename']; ?>
" name="entirename" type="text" size="45" style="width:360px;" tabindex="1"<?php if ($this->_tpl_vars['info']['realnamestatus'] == 2): ?> disabled="disabled"<?php endif; ?> /><span style="color:#ec6e0a;margin-left:5px;">*</span></td>
            </tr>
            <tr>
                <th align="right" width="90">组织简称：</th>
                <td><input class="text-big" value="<?php echo $this->_tpl_vars['org']['orgname']; ?>
" name="orgname" type="text" size="45" style="width:360px;" tabindex="1" /></td>
            </tr>
            <tr>
                <th align="right">所在地：</th>
                <td><select id="province-replace"><option></option></select>&nbsp;&nbsp;<select id="city-replace"><option></option></select><span style="color:#ec6e0a;margin-left:5px;">*</span></td>
            </tr>
            <tr>
                <th align="right">所属行业：</th>
                <td>
                    <select id="idu-replace"><option></option></select>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="form-field">
        <table border="0" cellspacing="0" cellpadding="5" class="table-form">
            <tr>
                <th align="right" width="90">组织联系人：</th>
                <td><input class="text-big" name="contact" type="text" size="45" style="width:360px;" value="<?php echo $this->_tpl_vars['info']['contact']; ?>
" tabindex="5" /><span style="color:#ec6e0a;margin-left:5px;">*</span></td>
            </tr>
            <tr>
                <th align="right">联系电话：</th>
                <td><input class="text-big" name="tel" type="text" size="45" style="width:360px;" value="<?php echo $this->_tpl_vars['info']['tel']; ?>
" tabindex="6" /><span style="color:#ec6e0a;margin-left:5px;">*</span></td>
            </tr>
            <tr>
                <th align="right">传真：</th>
                <td><input class="text-big" name="fax" type="text" size="45" style="width:360px;" value="<?php echo $this->_tpl_vars['info']['fax']; ?>
" tabindex="7" /></td>
            </tr>
            <tr>
                <th align="right">地址：</th>
                <td><input class="text-big" name="address" type="text" size="45" style="width:360px;" value="<?php echo $this->_tpl_vars['info']['address']; ?>
" tabindex="8" /><span style="color:#ec6e0a;margin-left:5px;">*</span></td>
            </tr>
            <tr>
                <th align="right">邮编：</th>
                <td><input class="text-big" name="postcode" type="text" size="45" style="width:360px;" value="<?php echo $this->_tpl_vars['info']['postcode']; ?>
" tabindex="9" /></td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="form-field">
        <table border="0" cellspacing="0" cellpadding="5" class="table-form">
            <tr>
                <th align="right" width="90" valign="top">组织简介：</th>
                <td><textarea class="text-big" id="intro" name="intro" cols="45" rows="5" style="width:360px; height:77px;" tabindex="10"><?php echo $this->_tpl_vars['org']['intro']; ?>
</textarea><span style="margin: 0 0 0 10px" class="gray" id="intro-hint">还可以输入300个字符</span></td>
            </tr>
        </table>
    </fieldset>
    <table border="0" cellspacing="0" cellpadding="5" class="table-form">
        <tr>
            <th align="right" width="90"></th>
            <td><input type="submit" value="保存修改" class="btn-big" tabindex="10" /></td>
        </tr>
    </table>
</form>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/frame.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['www']; ?>
/js/ui/base.js?1001" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['www']; ?>
/js/ui/select.js?1001" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/province.js?1001" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/industry.js?1001" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/org.js?1001" type="text/javascript"></script>
<script type="text/javascript">
<!--
Org.Info.init();
-->
</script>
</body>
</html>