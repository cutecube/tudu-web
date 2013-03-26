<?php
/**
 * Tudu_Install_Function
 *
 * @copyright  Copyright (c) 2009-2010 Shanghai Best Oray Information S&T CO., Ltd.
 * @link       http://www.oray.com/
 * @author     Oray-Yongfa
 * @version    $Id: Function.php 2794 2013-03-26 06:35:42Z chenyongfa $
 *
 */
Class Tudu_Install_Function
{
    /**
     * 当前进行的步骤
     *
     * @var int
     */
    protected $_step = 0;

    /**
     *
     * @var array
     */
    protected $_stepMethod = array('show_license', 'env_check', 'set_config', 'install', 'finish');

    /**
     * 
     * @var string
     */
    protected $_tplPath;

    /**
     *
     * @var Tudu_Install_Function
     */
    protected static $_instance;

    /**
     * 单例模式，隐藏构造函数
     */
    protected function __construct()
    {}

    /**
     * 获取对象实例
     *
     * @return Tudu_Install_Function
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * 创建对象实例
     *
     * @return Tudu_Install_Function
     */
    public static function newInstance()
    {
        return new self();
    }

    /**
     *
     * @param int $step
     */
    public function setStep($step)
    {
        $this->_step = (int) $step;
    }

    /**
     *
     * @param string $path
     */
    public function setTplPath($path)
    {
        $this->_tplPath = $path;
    }

    /**
     * 输出安装错误提示页面
     *
     * @param string $message
     * @throws Tudu_Install_Exception
     */
    public function error($message)
    {
        $tpl = $this->_tplPath . '/error.tpl';

        if (!file_exists($tpl) || !is_readable($tpl)) {
            require_once 'Tudu/Install/Exception.php';
            throw new Tudu_Install_Exception("Tpl file:\"{$tpl}\" is not exists");
        }

        $common = array('msg' => $message);

        $template = $this->_assignTpl(@file_get_contents($tpl), $common);
        echo $template;
        die;
    }

    /**
     * 处理Json输出
     *
     * @param boolean $success    操作是否成功
     * @param mixed   $params     附加参数
     * @param mixed   $data       返回数据
     * @param boolean $sendHeader 是否发送json文件头
     */
    public function json($success = false, $params = null, $data = false, $sendHeader = true)
    {
        if (is_string($params) || is_numeric($params)) {
            $params = array('message' => $params);
        }

        $json = array('success' => (boolean) $success);

        if (is_array($params)) {
            unset($params['success']);
            $json = array_merge($json, $params); // 可以让success优化显示
        }

        if (false !== $data) {
            $json['data'] = $data;
        }

        $content = json_encode($json);

        header('Content-Type: application/x-javascript; charset=utf-8');

        echo $content;

        exit;
    }

    /**
     * 输出页面模板
     *
     * @throws Tudu_Install_Exception
     */
    public function sendTemplate(array $options = null)
    {
        $tpl = $this->_tplPath . '/step_' . $this->_step . '.tpl';

        if (!file_exists($tpl) || !is_readable($tpl)) {
            require_once 'Tudu/Install/Exception.php';
            throw new Tudu_Install_Exception("Tpl file:\"{$tpl}\" is not exists");
        }

        $common = array('step' => $this->_step + 1);
        if (!empty($options)) {
            $common = array_merge($common, $options);
        }

        $template = $this->_assignTpl(@file_get_contents($tpl), $common);
        echo $template;
    }

    /**
     * 返回步骤
     *
     * @param int $step
     */
    public function getMethod($step = null)
    {
        if (empty($step)) {
            $step = $this->_step;
        }

        $method = $this->_stepMethod[$step];
        if (!in_array($method, $this->_stepMethod)) {
            $method = null;
        }

        return $method;
    }

    /**
     *
     * @param string $k
     * @param string $t
     */
    public function getgpc($k, $t='GP') {
        $t = strtoupper($t);

        switch($t) {
            case 'GP' : isset($_POST[$k]) ? $var = &$_POST : $var = &$_GET; break;
            case 'G': $var = &$_GET; break;
            case 'P': $var = &$_POST; break;
            case 'C': $var = &$_COOKIE; break;
            case 'R': $var = &$_REQUEST; break;
        }

        return isset($var[$k]) ? $var[$k] : null;
    }

    /**
     * 替换模板的数据
     *
     * @param string $tpl
     * @param array $data
     */
    private function _assignTpl($tpl, $data, $prefix = '')
    {
        $ret = $tpl;

        if (!empty($prefix)) {
            $prefix = $prefix . '.';
        }

        foreach ($data as $key => $val) {
            if (is_array($val)) {
                $ret = $this->_assignTpl($ret, $val, $prefix . $key);
            } else {
                $ret = str_replace('{$' . $prefix . $key . '}', $val, $ret);
            }
        }

        return $ret;
    }
}