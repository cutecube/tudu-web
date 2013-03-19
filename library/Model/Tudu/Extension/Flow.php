<?php
/**
 * Tudu Library
 *
 * LICENSE
 *
 *
 * @category   Tudu
 * @package    Tudu_Model
 * @copyright  Copyright (c) 2009-2010 Shanghai Best Oray Information S&T CO., Ltd.
 * @link       http://www.oray.com/
 * @version    $Id: Tudu.php 2070 2012-08-22 09:37:26Z cutecube $
 */

/**
 * @see Tudu_Dao_Manager
 */
require_once 'Tudu/Dao/Manager.php';

/**
 * @see Dao_Td_Tudu_Flow
 */
require_once 'Dao/Td/Tudu/Flow.php';

/**
 * @see Model_Tudu_Flow_Flow
 */
require_once 'Model/Tudu/Flow/Flow.php';

/**
 * @category   Model
 * @package    Model_Exception
 * @copyright  Copyright (c) 2009-2012 Shanghai Best Oray Information S&T CO., Ltd.
 */
class Model_Tudu_Flow extends Model_Tudu_Extension_Abstract
{

    /**
     *
     * @var string
     */
    protected $_handlerClass = 'Model_Tudu_Flow_Flow';

    /**
     *
     * @var array
     */
    protected $_attrs = array();

    /**
     *
     * @var array
     */
    protected $_steps = array();

    /**
     *
     * @var array
     */
    private $_depts;

    /**
     *
     * @var array
     */
    private $_addressBook;

    /**
     * Constructor
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = null)
    {
        if (!empty($attributes)) {
            $this->setAttributes($attributes);
        }
    }

    /**
     *
     * @param array $params
     * @return string
     */
    public function addStep(array $params)
    {
        if (!isset($params['type'])) {
            return false;
        }

        $stepId = isset($params['stepid']) ? $params['stepid'] : Dao_Td_Tudu_Flow::getStepId($this->_attrs['tuduid']);
        $prev   = end($this->_steps);
        $prevId = !$prev ? Model_Tudu_Flow_Flow::NODE_START : $prev['stepid'];

        $step = array(
            'stepid' => $stepId,
            'type'   => $params['type'],
            'section'=> array(),
            'prev'   => isset($params['prev']) ? $params['prev'] : $prevId,
            'next'   => isset($params['next']) ? $params['next'] : Model_Tudu_Flow_Flow::NODE_END
        );

        if (!empty($params['subject'])) {
            $step['subject'] = $params['subject'];
        }

        if (!empty($params['description'])) {
            $step['description'] = $params['description'];
        }

        // 上一步
        if (isset($this->_steps[$step['prev']])) {
            $prevStep = &$this->_steps[$step['prev']];

            if ($prevStep['next'] == Model_Tudu_Flow_Flow::NODE_END) {
                $prevStep['next'] = $stepId;
            }
        }

        // 调整排序
        if (isset($step['next']) && isset($this->_steps[$step['next']])) {
            $steps = array();

            if (0 !== strpos($this->_steps[$step['next']]['prev'], '^')) {
                $this->_steps[$step['next']]['prev'] = $stepId;
            }

            foreach ($this->_steps as $item) {
                if ($item['stepid'] == $step['next']) {
                    $steps[] = $step;
                }

                $steps[] = $item;
            }

            $this->_steps = $steps;

        } else {
            $this->_steps[] = $step;
        }

        return $stepId;
    }

    /**
     *
     * @param array $section
     */
    public function addStepSection($stepId, array $users)
    {
        if (!isset($this->_steps[$stepId])) {
            return false;
        }

        $step  = $this->_steps[$stepId];
        $orgId = $this->_attrs['orgid'];
        $sectionUsers = array();
        if (is_array($users)) {
            foreach ($users as $item) {
                $u = $this->_getAddressBook()->searchUser($orgId, $item['username']);

                if (!$u) {
                    require_once 'Model/Tudu/Exception.php';
                    throw new Model_Tudu_Exception('User in Tudu flow was not exists', Model_Tudu_Exception::FLOW_USER_NOT_EXISTS);
                }

                $sectionUsers[] = array(
                    'uniqueid' => $u['uniqueid'],
                    'truename' => $u['truename'],
                    'username' => $u['email'],
                    'deptid'   => !empty($u['deptid']) ? $u['deptid'] : '^root'
                );
            }

        // 上级/逐级
        } elseif (is_string($users)) {
            $prevUsers = array();
            // 上一步
            if (empty($step['section'])) {
                $prevStep  = $this->_steps[$step['prev']];
                $prevUsers = end($prevStep['section']);
            } else {
                $prevUsers = end($step['section']);
            }

            foreach ($prevUsers as $u) {
                $sectionUsers = $this->_getHeigherUsers($u['username'], isset($u['deptid']) ? $u['deptid'] : null, $step['section'] == '^uppers');
            }
        }

        $this->_steps[$stepId]['section'][] = $sectionUsers;

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getStepCount()
    {
        return count($this->_steps);
    }

    /**
     *
     * @return array:
     */
    public function getSteps()
    {
        return $this->_steps;
    }

    /**
     *
     * @param string $name
     */
    public function getAttribute($name)
    {
        $name = strtolower($name);

        if (empty($this->_attrs[$name])) {
            return null;
        }

        return $this->_attrs[$name];
    }

    /**
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $k => $val) {
            if ($k == 'steps') {
                $this->_steps = $val;
                continue ;
            }

            $this->setAttribute($k, $val);
        }

        return $this;
    }

    /**
     *
     * @param string $stepId
     */
    public function flowTo($stepId = null)
    {
        if (!isset($this->_steps[$this->stepId])) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Flow error', Model_Tudu_Exception::SAVE_FAILED);
        }

        // 不指定步骤，自动流到下一步
        if (null === $stepId) {
            $currentStep = &$this->_steps[$this->stepId];

            $sections     = $currentStep['sections'];
            $sectionIndex = $currentStep['currentSection'];
            // 还有下一段
            if (isset($sections[++$sectionIndex])) {
                $currentStep['currentSection'] = $sectionIndex;

                foreach ($currentStep['sections'][$sectionIndex] as &$item) {
                    $item['status'] = 1;
                }

            // 下一步骤
            } else {
                $nextStepId = $currentStep['next'];
                $this->currentStepId = $nextStepId;

                if (isset($this->_steps[$nextStepId])) {
                    $nextStep = &$this->_steps[$nextStepId];

                    $nextStep['currentSection'] = 0;

                    foreach ($nextStep['sections'][$nextStep['currentSection']] as &$item) {
                        $item['status'] = 1;
                    }
                }
            }

        } else {

            if (!isset($this->_steps[$stepId])) {
                require_once 'Model/Tudu/Exception.php';
                throw new Model_Tudu_Exception('Flow error', Model_Tudu_Exception::SAVE_FAILED);
            }

            $this->currentStepId = $stepId;
            $nextStep = &$this->_steps[$stepId];
            $nextStep['currentSection'] = 0;
            foreach ($nextStep['sections'][$nextStep['currentSection']] as &$item) {
                $item['status'] = 1;
            }
        }
    }

    /**
     *
     * @param string $stepId
     */
    public function deleteStep($stepId)
    {
        if (!isset($this->_steps[$stepId])) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Flow error', Model_Tudu_Exception::SAVE_FAILED);
        }

        $delete = $this->_steps[$stepId];
        $steps  = array();
        foreach ($this->_steps as $item) {
            if ($item['stepid'] == $stepId) {
                continue ;
            }

            if ($item['prev'] == $stepId) {
                $item['prev'] = $delete['prev'];
            }

            if ($item['next'] == $stepId) {
                $item['next'] = $delete['next'];
            }

            $steps[] = $item;
        }

        $this->_steps = $steps;
    }

    /**
     *
     * @return multitype:
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }

    /**
     * 获取当前执行人
     */
    public function getCurrentUser()
    {
        if (!isset($this->_steps[$this->currentStepId])) {
            return array();
        }

        $currentStep = $this->_steps[$this->currentStepId];

        if (!isset($currentStep['sections'][$currentStep['currentSection']])) {
            return array();
        }

        return $currentStep['sections'][$currentStep['currentSection']];
    }

    /**
     *
     */
    public function toArray()
    {
        $ret = $this->_attrs;
        $ret['steps'] = $this->_steps;

        return $ret;
    }

    /**
     *
     * @param string $name
     */
    public function __get($name)
    {
        if ($name == 'steps') {
            return $this->_steps;
        }
        return $this->getAttribute($name);
    }

    /**
     *
     * @param string $name
     */
    public function __set($name, $value)
    {
        if ($name == 'steps') {
            return $this->_steps = $value;
        }
        $this->setAttribute($name, $value);
    }

    /**
     *
     * @param string $userName
     */
    private function _getDepts($orgId)
    {
        if (empty($this->_depts)) {
            /* @var Dao_Md_Department_Department */
            $daoDepts = Tudu_Dao_Manager::getDao('Dao_Md_Department_Department', Tudu_Dao_Manager::DB_MD);

            $this->_depts = $daoDepts->getDepartments(array(
            'orgid'  => $orgId
            ))->toArray('deptid');
        }

        return $this->_depts;
    }

    /**
     *
     * @return Tudu_AddressBook
     */
    private function _getAddressBook()
    {
        if (null === $this->_addressbook) {
            $this->_addressbook = Tudu_AddressBook::getInstance();
        }

        return $this->_addressbook;
    }

    /**
     *
     * @param string  $userName
     * @param string  $orgId
     * @param boolean $isDeep
     * @return array
     */
    private function _getHeigherUsers($userName, $deptId = null, $isDeep = false)
    {
        list($userId, $orgId) = explode('@', $userName);

        if (null === $deptId) {
            $user = $this->_getAddressBook()->searchUser($orgId, $userName);

            if (null === $user) {
                require_once 'Model/Tudu/Exception.php';
                throw new Model_Tudu_Exception('User in Tudu flow was not exists', Model_Tudu_Exception::FLOW_USER_NOT_EXISTS);
            }

            $deptId = $user['deptid'];
        }

        $depts = $this->_getDepts($orgId);

        if (empty($depts[$deptId])) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('User in Tudu flow was not exists', Model_Tudu_Exception::FLOW_USER_NOT_EXISTS);
        }

        $dept = $depts[$deptId];

        if (empty($dept['moderators'])) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('User in Tudu flow was not exists', Model_Tudu_Exception::FLOW_USER_NOT_EXISTS);
        }

        $ret = array();
        $sec = array();
        // 是当前部门负责人
        if (in_array($userId, $dept['moderators']) && $deptId != '^root' && $deptId !== NULL) {
            $dept = $depts[$dept['parentid']];
        }

        foreach ($dept['moderators'] as $m) {
            $user  = $this->_getAddressBook()->searchUser($orgId, $m . '@' . $orgId);
            if (null == $user) {
                require_once 'Model/Tudu/Exception.php';
                throw new Model_Tudu_Exception('User in Tudu flow was not exists', Model_Tudu_Exception::FLOW_USER_NOT_EXISTS);
            }

            $sec[] = array('username' => $user['email'], 'truename' => $user['truename']);
        }
        $ret[] = $sec;

        // 递归上级
        if ($isDeep) {
            while (!empty($dept['parentid']) && isset($depts[$dept['parentid']])) {
                $dept = $depts[$dept['parentid']];

                $sec = array();
                foreach ($dept['moderators'] as $m) {
                    $user  = $this->_getAddressBook()->searchUser($orgId, $m . '@' . $orgId);
                    if (null == $user) {
                        require_once 'Model/Tudu/Exception.php';
                        throw new Model_Tudu_Exception('User in Tudu flow was not exists', Model_Tudu_Exception::FLOW_USER_NOT_EXISTS);
                    }

                    $sec[] = array('username' => $user['email'], 'truename' => $user['truename']);
                }
                $ret[] = $sec;
            }
        }

        return $ret;
    }
}