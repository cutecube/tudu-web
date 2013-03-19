<?php /* Smarty version 2.6.26, created on 2013-03-15 12:01:32
         compiled from user/group%23index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'str_replace', 'user/group#index.tpl', 42, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>群组管理</title>
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
/js/frame.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/group.js?1002" type="text/javascript"></script>
</head>
<body>

<p style="padding:4px 5px 9px; height:16px;line-height:16px;"><strong class="f14 text-title">群组</strong>&nbsp;<a href="http://service.oray.com/question/706.html" target="_blank" title="群组？" class="icon icon-question"></a></p>
<div id="float-toolbar" class="float-toolbar">
<div class="toolbar">
    <input name="create" class="btn wd85" value="新建群组" type="button" />
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-list table-header">
    <tr>
        <th class="td-first" align="left"><div class="td-space">群组名称</div></th>
        <th width="160" class="td-last" align="left"><div class="td-space">操作</div></th>
        <th width="50" align="left"><div class="td-space">排序</div></th>
    </tr>
</table>
</div>
<div id="toolbar">
<div class="toolbar">
	<input name="create" class="btn wd80" value="新建群组" type="button" />
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-list table-header">
    <tr>
        <th class="td-first" align="left"><div class="td-space">群组名称</div></th>
        <th width="160" class="td-last" align="left"><div class="td-space">操作</div></th>
        <th width="50" align="left"><div class="td-space">排序</div></th>
    </tr>
</table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-list">
	<tbody id="group-list">
	<?php $_from = $this->_tpl_vars['groups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['group'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['group']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['group']):
        $this->_foreach['group']['iteration']++;
?>
	<tr id="group-<?php echo ((is_array($_tmp='^')) ? $this->_run_mod_handler('str_replace', true, $_tmp, '_', $this->_tpl_vars['group']['groupid']) : str_replace($_tmp, '_', $this->_tpl_vars['group']['groupid'])); ?>
" _gid="<?php echo $this->_tpl_vars['group']['groupid']; ?>
">
		<td class="td-first"><div class="td-space"><?php echo $this->_tpl_vars['group']['groupname']; ?>
</div></td>
		<td width="160"><div class="td-space"><a href="javascript:void(0);" onclick="Group.member('<?php echo $this->_tpl_vars['group']['groupid']; ?>
');">[成员]</a><?php if (! $this->_tpl_vars['group']['issystem']): ?> <a href="javascript:void(0);" onclick="Group.update('<?php echo $this->_tpl_vars['group']['groupid']; ?>
', '<?php echo $this->_tpl_vars['group']['groupname']; ?>
')">[重命名]</a> <a href="javascript:void(0);" onclick="Group.del('<?php echo $this->_tpl_vars['group']['groupid']; ?>
')">[删除]</a><?php endif; ?></div></td>
		<td width="50" class="td-last"><div class="td-space"><a href="javascript:void(0);"<?php if (($this->_foreach['group']['iteration']-1) == 0): ?> class="lightgray"<?php else: ?> onclick="Group.sortGroup('<?php echo $this->_tpl_vars['group']['groupid']; ?>
', 'up');"<?php endif; ?>>↑</a> <a href="javascript:void(0);"<?php if (($this->_foreach['group']['iteration']-1) == count ( $this->_tpl_vars['groups'] ) - 1): ?> class="lightgray"<?php else: ?> onclick="Group.sortGroup('<?php echo $this->_tpl_vars['group']['groupid']; ?>
', 'down');"<?php endif; ?>>↓</a></div></td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	</tbody>
</table>
<div class="list-btm-bar"></div>

<script type="text/javascript">
<!--
$(function() {
	_TOP.switchMod('group');
	Group.init();

	new FixToolbar({
        src: '#toolbar',
        target: '#float-toolbar'
    });
});
-->
</script>
</body>
</html>