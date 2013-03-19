<?php /* Smarty version 2.6.26, created on 2013-03-15 16:11:43
         compiled from user/user%23add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urlencode', 'user/user#add.tpl', 14, false),array('modifier', 'str_replace', 'user/user#add.tpl', 67, false),array('modifier', 'date_format', 'user/user#add.tpl', 126, false),array('modifier', 'replace', 'user/user#add.tpl', 163, false),array('modifier', 'escape', 'user/user#add.tpl', 163, false),array('function', 'math', 'user/user#add.tpl', 130, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加账号</title>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "^style.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery.tree.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/jquery.checkbox.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/frame.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/user.js?1010" type="text/javascript"></script>
</head>
<body>
<?php $this->assign('currUrl', ((is_array($_tmp=$_SERVER['REQUEST_URI'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp))); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user/^nav.tpl", 'smarty_include_vars' => array('tab' => 'add')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form action="<?php echo $this->_tpl_vars['basepath']; ?>
/user/user/create" id="theform" method="post">
    <table id="user-base" border="0" cellspacing="2" cellpadding="3" class="table-form table-form-f12" style="margin-top:20px;margin-bottom:40px;">
        <tr>
            <th width="110" align="right"><label for="account">登录帐号：</label></th>
            <td><input name="userid" type="text" class="text" id="userid" title="请输入英文、数字" maxlength="16" style="ime-mode:disabled;width:250px" />&nbsp;&nbsp;@<?php echo $this->_tpl_vars['org']['orgid']; ?>
<input type="hidden" name="domainid" value="<?php echo $this->_tpl_vars['domain']['domainid']; ?>
" /><span id="hint-userid" style="margin-left:10px;"></span></td>
        </tr>
        <tr>
            <th align="right"><label for="password">密码：</label></th>
            <td><input name="password" type="text" class="text" id="password"  value="<?php echo $this->_tpl_vars['org']['defaultpassword']; ?>
" maxlength="16" style="ime-mode:disabled;width:250px" />&nbsp;&nbsp;<span class="gray" id="hint-password" style="display:none">用于登录图度系统。最长不超过16字符</span></td>
        </tr>
        <tr>
            <th align="right"><label for="name">真实姓名：</label></th>
            <td><input name="truename" type="text" class="text" id="truename" value="" style="width:250px" />&nbsp;&nbsp;<span class="gray" id="hint-truename" style="display:none">姓名在通讯录中显示</span></td>
        </tr>
        <tr>
            <th align="right">帐号状态：</th>
            <td><select name="status" style="width:256px"><option value="1">正式</option><option value="2">临时</option></select></td>
        </tr>
        <tr>
            <th align="right">性别：</th>
            <td><select name="gender" style="width:256px"><option value="1">男</option><option value="0">女</option></select></td>
        </tr>
        <tr>
            <th valign="top" align="right"><p style=" padding-top:3px;">所属部门：</p></th>
            <td>
                <p><select name="deptid" id="department" style="width:256px;">
                <option value="">请选择部门</option>
                <?php $_from = $this->_tpl_vars['depts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                <?php if ($this->_tpl_vars['item']['deptid'] != '^root'): ?>
                <option value="<?php echo $this->_tpl_vars['item']['deptid']; ?>
"><?php echo $this->_tpl_vars['item']['prefix']; ?>
<?php echo $this->_tpl_vars['item']['deptname']; ?>
</option>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <option value="^new">新建部门</option>
                </select></p>
                <p style="margin-top:8px;display:none" id="new-dept"><select name="dept-parent" style="width:160px;">
                <option value="">无上级部门</option>
                <?php $_from = $this->_tpl_vars['depts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                <?php if ($this->_tpl_vars['item']['deptid'] != '^root'): ?>
                <option value="<?php echo $this->_tpl_vars['item']['deptid']; ?>
"><?php echo $this->_tpl_vars['item']['prefix']; ?>
<?php echo $this->_tpl_vars['item']['deptname']; ?>
</option>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                </select>&nbsp;
                    <input name="deptname" type="text" class="text" value="" style="width:83px;" /> <span class="gray" style="margin-left:5px;">选择新部门所属上级部门，并填写新部门名称</span>
                </p>
            </td>
        </tr>
        <tr>
            <th valign="top" align="right"><p style=" padding-top:3px;">帐号权限：</p></th>
            <td>
                <div id="role-list" <?php if (count ( $this->_tpl_vars['roles'] ) > 5): ?> class="box"<?php endif; ?>>
                <?php $_from = $this->_tpl_vars['roles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                <p><label for="role-<?php echo ((is_array($_tmp='^')) ? $this->_run_mod_handler('str_replace', true, $_tmp, '_', $this->_tpl_vars['item']['roleid']) : str_replace($_tmp, '_', $this->_tpl_vars['item']['roleid'])); ?>
"><input type="checkbox" value=<?php echo $this->_tpl_vars['item']['roleid']; ?>
 name="roleid[]" id="role-<?php echo ((is_array($_tmp='^')) ? $this->_run_mod_handler('str_replace', true, $_tmp, '_', $this->_tpl_vars['item']['roleid']) : str_replace($_tmp, '_', $this->_tpl_vars['item']['roleid'])); ?>
"<?php if ($this->_tpl_vars['item']['roleid'] == '^user'): ?> checked="checked"<?php endif; ?> /><?php echo $this->_tpl_vars['item']['rolename']; ?>
</label><?php if ($this->_tpl_vars['item']['roleid'] == '^user'): ?>(基本权限)<?php elseif ($this->_tpl_vars['item']['roleid'] == '^advanced'): ?>(中高层管理者权限)<?php elseif ($this->_tpl_vars['item']['roleid'] == '^admin'): ?>(拥有前后台最高权限)<?php endif; ?></p>
                <?php endforeach; endif; unset($_from); ?>
                </div>
            </td>
        </tr>
        <tr>
            <th valign="top" align="right"><p style="padding-top:3px;">网盘空间：</p></th>
            <td>
                <p><input name="maxndquota" type="text" class="text" value="10" size="10" maxlength="6" style="ime-mode:disabled" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9.]+/,'');}).call(this)" onblur="this.v();" /> MB</p>
            </td>
        </tr>
        <tr>
            <th align="right"> </th>
            <td><p style="margin:10px 0;"><a name="moreinfo" id="moreinfo-icon" href="javascript:void(0);" class="icon icon-fold"></a> <a name="moreinfo" href="javascript:void(0);"><span id="more-detail">展开帐号详细信息</span></a></p></td>
        </tr>
    </table>
    <table id="info" style="display:none; margin:0 0 40px 25px;" border="0" cellspacing="2" cellpadding="3" class="table-form table-form-f12">
        <tr>
            <th valign="top" align="right"><p style=" padding-top:3px;">显示在通讯录：</p></th>
            <td>
                <p><label for="yes"><input id="yes" checked="checked" name="isshow" type="radio" value="1" />是</label>&nbsp;&nbsp;显示排序为 <input name="ordernum" type="text" class="text" value="1" size="10" maxlength="4" style="ime-mode:disabled" />&nbsp;&nbsp;<span class="gray" id="hint-order">输入的数字越大，排序越靠前</span></p>
                <p style="margin-top:8px;"><label for="no"><input id="no" name="isshow" type="radio" value="0" />否</label></p>
            </td>
        </tr>
        <tr>
            <th align="right"><label for="position">职位：</label></th>
            <td><input name="position" type="text" id="position" class="text" style="width:250px;" maxlength="50" /></td>
        </tr>
        <tr>
            <th valign="top"  align="right">所属群组：</th>
            <td>
                <div id="group-list" <?php if (count ( $this->_tpl_vars['groups'] ) > 5): ?> class="box"<?php endif; ?>>
                <?php $_from = $this->_tpl_vars['groups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                <p><label for="group-<?php echo ((is_array($_tmp='^')) ? $this->_run_mod_handler('str_replace', true, $_tmp, '_', $this->_tpl_vars['item']['groupid']) : str_replace($_tmp, '_', $this->_tpl_vars['item']['groupid'])); ?>
"><input type="checkbox" value=<?php echo $this->_tpl_vars['item']['groupid']; ?>
 name="groupid[]" id="group-<?php echo ((is_array($_tmp='^')) ? $this->_run_mod_handler('str_replace', true, $_tmp, '_', $this->_tpl_vars['item']['groupid']) : str_replace($_tmp, '_', $this->_tpl_vars['item']['groupid'])); ?>
"<?php if ($this->_tpl_vars['item']['groupid'] == '^all'): ?> checked="checked"<?php endif; ?> /><?php echo $this->_tpl_vars['item']['groupname']; ?>
</label></p>
                <?php endforeach; endif; unset($_from); ?>
                </div>
                <p style="margin:8px 0;"><input name="groupname" id="groupname" type="text" class="text" title="请输入新群组名称" maxlength="20" style="width:250px;" />&nbsp;<a id="create-group" class="icon icon-add" href="javascript:void(0);"></a><span class="gray" style="margin-left:10px;">一般用于跨部门的群体组合，如全体部门经理组 <a href="http://service.oray.com/question/706.html" target="_blank">更多帮助</a></span></p>
            </td>
        </tr>
        <tr>
            <th valign="top" align="right">组织架构视图：</th>
            <td>
                <p style="margin-bottom:8px;">在此设置帐号可见的组织架构</p>
                <div class="box">
                <div id="tree-ct"></div>
                </div>
            </td>
        </tr>
        <tr>
            <th align="right"><label for="user-email">邮箱：</label></th>
            <td><input id="user-email" name="email" type="text" class="text" style="width:250px;" /></td>
        </tr>
        <tr>
            <th align="right"><label for="id-number">身份证号：</label></th>
            <td><input id="id-number" name="idnumber" type="text" class="text" style="width:250px;" /></td>
        </tr>
        <tr>
            <th align="right">出生日期：</th>
            <td>
                <?php $this->assign('year', ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y"))); ?>
                <select style="width:90px;" name="bir-year" id="bir-year">
                <option value="">-</option>
                <?php unset($this->_sections['year']);
$this->_sections['year']['name'] = 'year';
$this->_sections['year']['loop'] = is_array($_loop=70) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['year']['show'] = true;
$this->_sections['year']['max'] = $this->_sections['year']['loop'];
$this->_sections['year']['step'] = 1;
$this->_sections['year']['start'] = $this->_sections['year']['step'] > 0 ? 0 : $this->_sections['year']['loop']-1;
if ($this->_sections['year']['show']) {
    $this->_sections['year']['total'] = $this->_sections['year']['loop'];
    if ($this->_sections['year']['total'] == 0)
        $this->_sections['year']['show'] = false;
} else
    $this->_sections['year']['total'] = 0;
if ($this->_sections['year']['show']):

            for ($this->_sections['year']['index'] = $this->_sections['year']['start'], $this->_sections['year']['iteration'] = 1;
                 $this->_sections['year']['iteration'] <= $this->_sections['year']['total'];
                 $this->_sections['year']['index'] += $this->_sections['year']['step'], $this->_sections['year']['iteration']++):
$this->_sections['year']['rownum'] = $this->_sections['year']['iteration'];
$this->_sections['year']['index_prev'] = $this->_sections['year']['index'] - $this->_sections['year']['step'];
$this->_sections['year']['index_next'] = $this->_sections['year']['index'] + $this->_sections['year']['step'];
$this->_sections['year']['first']      = ($this->_sections['year']['iteration'] == 1);
$this->_sections['year']['last']       = ($this->_sections['year']['iteration'] == $this->_sections['year']['total']);
?>
                <option value="<?php echo smarty_function_math(array('equation' => ($this->_tpl_vars['year'])."-x",'x' => $this->_sections['year']['index']), $this);?>
" <?php if ($this->_tpl_vars['year'] - $this->_tpl_vars['userinfo']['birthyear'] == $this->_sections['year']['index']): ?> selected="selected"<?php endif; ?>><?php echo smarty_function_math(array('equation' => ($this->_tpl_vars['year'])."-x",'x' => $this->_sections['year']['index']), $this);?>
</option>
                <?php endfor; endif; ?>
                </select>
                <select style="width:80px;" name="bir-month" id="bir-month">
                <option value="">-</option>
                <?php unset($this->_sections['month']);
$this->_sections['month']['name'] = 'month';
$this->_sections['month']['loop'] = is_array($_loop=12) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['month']['show'] = true;
$this->_sections['month']['max'] = $this->_sections['month']['loop'];
$this->_sections['month']['step'] = 1;
$this->_sections['month']['start'] = $this->_sections['month']['step'] > 0 ? 0 : $this->_sections['month']['loop']-1;
if ($this->_sections['month']['show']) {
    $this->_sections['month']['total'] = $this->_sections['month']['loop'];
    if ($this->_sections['month']['total'] == 0)
        $this->_sections['month']['show'] = false;
} else
    $this->_sections['month']['total'] = 0;
if ($this->_sections['month']['show']):

            for ($this->_sections['month']['index'] = $this->_sections['month']['start'], $this->_sections['month']['iteration'] = 1;
                 $this->_sections['month']['iteration'] <= $this->_sections['month']['total'];
                 $this->_sections['month']['index'] += $this->_sections['month']['step'], $this->_sections['month']['iteration']++):
$this->_sections['month']['rownum'] = $this->_sections['month']['iteration'];
$this->_sections['month']['index_prev'] = $this->_sections['month']['index'] - $this->_sections['month']['step'];
$this->_sections['month']['index_next'] = $this->_sections['month']['index'] + $this->_sections['month']['step'];
$this->_sections['month']['first']      = ($this->_sections['month']['iteration'] == 1);
$this->_sections['month']['last']       = ($this->_sections['month']['iteration'] == $this->_sections['month']['total']);
?>
                <option value="<?php echo smarty_function_math(array('equation' => "x+1",'x' => $this->_sections['month']['index']), $this);?>
" <?php if ($this->_tpl_vars['userinfo']['birthmonth'] - 1 == $this->_sections['month']['index']): ?> selected="selected"<?php endif; ?>><?php echo smarty_function_math(array('equation' => "x+1",'x' => $this->_sections['month']['index']), $this);?>
</option>
                <?php endfor; endif; ?>
                </select>
                <select style="width:78px;" name="bir-day" id="bir-day"><option value="">-</option></select>
            </td>
        </tr>
        <tr>
            <th align="right"><label for="cell-phone">手机号：</label></th>
            <td><input id="mobile" name="mobile" type="text" class="text" style="width:250px;" maxlength="30" /></td>
        </tr>
        <tr>
            <th align="right"><label for="phone">办公电话：</label></th>
            <td><input id="tel" name="tel" type="text" class="text" style="width:250px;" /></td>
        </tr>
        <tr>
            <th align="right"> </th>
            <td></td>
        </tr>
    </table>
    <div class="tool-btm"><div class="toolbar"><input type="submit" class="btn wd50" value="提 交"/></div>

</form>

<script type="text/javascript">
<!--
var depts = [];
<?php $_from = $this->_tpl_vars['depts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
depts.push({deptid:'<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['deptid'])) ? $this->_run_mod_handler('replace', true, $_tmp, "^", '_') : smarty_modifier_replace($_tmp, "^", '_')); ?>
', deptname: '<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['deptname'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
', parentid: '<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['parentid'])) ? $this->_run_mod_handler('replace', true, $_tmp, "^", '_') : smarty_modifier_replace($_tmp, "^", '_')); ?>
'});
<?php endforeach; endif; unset($_from); ?>
var _ORG_NAME = '<?php echo $this->_tpl_vars['org']['orgname']; ?>
';
$(function() {
    _TOP.switchMod('user');
    User.depts = depts;
    User.initCreate();
});
-->
</script>
</body>
</html>