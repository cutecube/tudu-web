<?php /* Smarty version 2.6.26, created on 2013-03-15 11:39:21
         compiled from user/department%23index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'user/department#index.tpl', 50, false),array('modifier', 'escape', 'user/department#index.tpl', 50, false),array('modifier', 'default', 'user/department#index.tpl', 52, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>组织架构</title>
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
<script src="<?php echo $this->_tpl_vars['options']['sites']['www']; ?>
/js/ui/base.js?1001" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['www']; ?>
/js/ui/select.js?1001" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['options']['sites']['static']; ?>
/js/department.js?1004" type="text/javascript"></script>
</head>
<body>

<p style="padding:4px 5px 9px; height:16px;line-height:16px;"><strong class="f14 text-title">组织架构</strong></p>
<div id="float-toolbar" class="float-toolbar">
<div class="toolbar">
    <input name="create" type="button" class="btn wd85" value="新建部门"/>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-list">
    <tr>
        <th class="td-first" align="left"><div class="td-space">部门名称</div></th>
        <th width="170" align="left"><div class="td-space">负责人</div></th>
        <th width="210" align="left"><div class="td-space">操作</div></th>
        <th width="50" class="td-last" align="left"><div class="td-space">排序</div></th>
    </tr>
</table>
</div>
<div id="toolbar">
<div class="toolbar">
    <input name="create" type="button" class="btn wd80" value="新建部门"/>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-list">
    <tr>
        <th class="td-first" align="left"><div class="td-space">部门名称</div></th>
        <th width="170" align="left"><div class="td-space">负责人</div></th>
        <th width="210" align="left"><div class="td-space">操作</div></th>
        <th width="50" class="td-last" align="left"><div class="td-space">排序</div></th>
    </tr>
</table>
</div>
<div id="dept-list" style="background:#fff;">
</div>
<div class="list-btm-bar"></div>

<script type="text/javascript">
var _DEPTS = [];
<?php $_from = $this->_tpl_vars['depts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
_DEPTS.push({deptid: '<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['deptid'])) ? $this->_run_mod_handler('replace', true, $_tmp, "^", '_') : smarty_modifier_replace($_tmp, "^", '_')); ?>
', deptname: '<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['deptname'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
', moderators: [<?php $_from = $this->_tpl_vars['item']['moderators']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['moderator']):
        $this->_foreach['foo']['iteration']++;
?><?php if (! ($this->_foreach['foo']['iteration'] <= 1)): ?>,<?php endif; ?>'<?php echo ((is_array($_tmp=$this->_tpl_vars['moderator'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
'<?php endforeach; endif; unset($_from); ?>], parentid: '<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['parentid'])) ? $this->_run_mod_handler('replace', true, $_tmp, "^", '_') : smarty_modifier_replace($_tmp, "^", '_')); ?>
', ordernum: '<?php echo $this->_tpl_vars['item']['ordernum']; ?>
', prefix: '<?php echo $this->_tpl_vars['item']['prefix']; ?>
', 'firstnode': <?php if ($this->_tpl_vars['item']['firstnode']): ?>1<?php else: ?>0<?php endif; ?>, 'lastnode': <?php if ($this->_tpl_vars['item']['lastnode']): ?>1<?php else: ?>0<?php endif; ?>});
<?php endforeach; endif; unset($_from); ?>
var _ORGNAME = '<?php echo ((is_array($_tmp=@$this->_tpl_vars['org']['orgname'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['org']['orgid']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['org']['orgid'])); ?>
';
_TOP.switchMod('dept');
Department.init(_DEPTS, _ORGNAME);

new FixToolbar({
    src: '#toolbar',
    target: '#float-toolbar'
});
</script>
</body>
</html>