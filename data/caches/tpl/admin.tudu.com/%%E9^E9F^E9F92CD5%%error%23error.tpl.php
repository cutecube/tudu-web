<?php /* Smarty version 2.6.26, created on 2013-03-15 11:35:36
         compiled from default/error%23error.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'var_export', 'default/error#error.tpl', 23, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Error</title>
</head>
<body>
  <h1>An error occurred</h1>
  <h2><?php echo $this->_tpl_vars['message']; ?>
</h2>

  <?php if ($this->_tpl_vars['exception']): ?>

  <h3>Exception information:</h3>
  <p>
      <b>Message:</b> <?php echo $this->_tpl_vars['exception']->getMessage(); ?>

  </p>

  <h3>Stack trace:</h3>
  <pre><?php echo $this->_tpl_vars['exception']->getTraceAsString(); ?>

  </pre>

  <h3>Request Parameters:</h3>
  <pre><?php echo $this->_plugins['function']['var_export'][0][0]->varExport(array('_params' => $this->_tpl_vars['request']->getParams()), $this);?>

  </pre>
  <?php endif; ?>

</body>
</html>