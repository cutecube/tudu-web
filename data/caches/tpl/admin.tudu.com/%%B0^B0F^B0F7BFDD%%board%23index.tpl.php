<?php /* Smarty version 2.6.26, created on 2013-03-15 13:18:49
         compiled from board/board%23index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'board/board#index.tpl', 48, false),array('modifier', 'replace', 'board/board#index.tpl', 54, false),array('modifier', 'escape', 'board/board#index.tpl', 54, false),array('modifier', 'count', 'board/board#index.tpl', 54, false),array('modifier', 'is_group', 'board/board#index.tpl', 54, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分区管理</title>
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
/js/board.js?1003" type="text/javascript"></script>
</head>
<body>

<p style="padding:4px 5px 9px; height:16px;line-height:16px;"><strong class="f14 text-title">分区管理</strong>&nbsp;<a href="http://service.oray.com/question/539.html" target="_blank" title="版块分区？" class="icon icon-question"></a></p>
<div id="float-toolbar" class="float-toolbar">
<div class="toolbar">
    <div class="btn-drop"><div class="icon btn-arrow"></div><input name="create" type="button" class="btn wd90 select-menu" value="新建分区" style="margin:0" /></div><span class="toolbar-space"></span><input name="merge" type="button" class="btn wd80" value="合并分区" />
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-list">
    <tr>
        <th class="td-first" align="left"><div class="td-space">分区名称</div></th>
        <th width="210" align="left"><div class="td-space">分区负责人</div></th>
        <th width="250" align="left"><div class="td-space">操作</div></th>
        <th width="50" align="left" class="td-last"><div class="td-space">排序</div></th>
    </tr>
</table>
</div>

<div id="toolbar">
<div class="toolbar">
	<div class="btn-drop"><div class="icon btn-arrow"></div><input name="create" type="button" class="btn wd90 select-menu" value="新建分区" style="margin:0" /></div><span class="toolbar-space"></span><input name="merge" type="button" class="btn wd80" value="合并分区" />
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-list">
	<tr>
		<th class="td-first" align="left"><div class="td-space">分区名称</div></th>
		<th width="210" align="left"><div class="td-space">分区负责人</div></th>
		<th width="250" align="left"><div class="td-space">操作</div></th>
		<th width="50" align="left" class="td-last"><div class="td-space">排序</div></th>
	</tr>
</table>
</div>
<div id="board-list">
</div>
<div class="list-btm-bar"></div>

<?php $this->assign('org', ((is_array($_tmp='@')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['orgid']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['orgid']))); ?>
<script type="text/javascript">
<!--
var boards = [];
<?php $_from = $this->_tpl_vars['boards']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<?php if ($this->_tpl_vars['item']['boardid'] != '^system' && $this->_tpl_vars['item']['boardid'] != '^app-attend'): ?>
boards.push({boardid: '<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['boardid'])) ? $this->_run_mod_handler('replace', true, $_tmp, '^', '_') : smarty_modifier_replace($_tmp, '^', '_')); ?>
', boardname: '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['boardname'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
', parentid: '<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['parentid'])) ? $this->_run_mod_handler('replace', true, $_tmp, "^", '_') : smarty_modifier_replace($_tmp, "^", '_')); ?>
', ordernum: '<?php echo $this->_tpl_vars['item']['ordernum']; ?>
', type: '<?php echo $this->_tpl_vars['item']['type']; ?>
', moderators: '<?php $_from = $this->_tpl_vars['item']['moderators']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['moderator']):
        $this->_foreach['foo']['iteration']++;
?><?php if (! ($this->_foreach['foo']['iteration'] <= 1)): ?>,<?php endif; ?><?php echo $this->_tpl_vars['key']; ?>
<?php endforeach; endif; unset($_from); ?>', moderatorsName: '<?php if (count($this->_tpl_vars['item']['moderators']) <= 0): ?>-<?php else: ?><?php $_from = $this->_tpl_vars['item']['moderators']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['moderator']):
        $this->_foreach['foo']['iteration']++;
?><?php if (! ($this->_foreach['foo']['iteration'] <= 1)): ?>,<?php endif; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['moderator'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
<?php endforeach; endif; unset($_from); ?><?php endif; ?>', groups: '<?php if ($this->_tpl_vars['item']['type'] == 'board'): ?><?php $_from = $this->_tpl_vars['item']['groups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['groups'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['groups']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['group']):
        $this->_foreach['groups']['iteration']++;
?><?php if (! ($this->_foreach['groups']['iteration'] <= 1)): ?>,<?php endif; ?><?php if (((is_array($_tmp=$this->_tpl_vars['group'])) ? $this->_run_mod_handler('is_group', true, $_tmp) : $this->_plugins['modifier']['is_group'][0][0]->isGroup($_tmp))): ?>group_<?php endif; ?><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['group'])) ? $this->_run_mod_handler('replace', true, $_tmp, ($this->_tpl_vars['org']), "") : smarty_modifier_replace($_tmp, ($this->_tpl_vars['org']), "")))) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
<?php endforeach; endif; unset($_from); ?><?php endif; ?>'});
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
Board.boards = boards;
$(function() {
	_TOP.switchMod('board');
	Board.init();

	new FixToolbar({
        src: '#toolbar',
        target: '#float-toolbar'
    });
});
-->
</script>
</body>
</html>