<?php
/**
 * Tudu Library
 *
 * LICENSE
 *
 *
 * @category   Model
 * @package    Model_Auth
 * @copyright  Copyright (c) 2009-2010 Shanghai Best Oray Information S&T CO., Ltd.
 * @link       http://www.oray.com/
 * @version    $Id: Exception.php 1894 2012-05-31 08:02:57Z cutecube $
 */

/**
 * @see Model_Abstract
 */
require_once 'Model/Abstract.php';

/**
 * 业务模型抛出异常基类
 *
 * @category   Model
 * @package    Model_Auth
 * @copyright  Copyright (c) 2009-2010 Shanghai Best Oray Information S&T CO., Ltd.
 */
class Model_Tudu_Flow_Flow extends Model_Abstract
{
    /**
     *
     * @var string
     */
    const NODE_START = '^start';
    const NODE_BREAK = '^break';
    const NODE_END   = '^end';

    /**
     *
     * @var int
     */
    const STEP_TYPE_EXECUTE = 0;
    const STEP_TYPE_EXAMINE = 1;
    const STEP_TYPE_CLAIM   = 2;

    /**
     *
     * @param Model_Tudu_Tudu $tudu
     */
    public function flowTo(Model_Tudu_Tudu &$tudu, $stepId = null)
    {
        /* @var $daoFlow Dao_Td_Tudu_Flow */
        $daoFlow = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Flow', Tudu_Dao_Manager::DB_TS);
    }

    /**
     *
     * @param Model_Tudu_Tudu $tudu
     */
    public function updateFlow(Model_Tudu_Extension_Flow $flow, $cancelCurrent = false)
    {
        /* @var $daoFlow Dao_Td_Tudu_Flow */
        $daoFlow = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Flow', Tudu_Dao_Manager::DB_TS);

        if (!$daoFlow->updateFlow($flow->tuduId, $flow->toArray())) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Tudu flow save failed', Model_Tudu_Exception::SAVE_FAILED);
        }
    }

    /**
     *
     * @param MOdel_Tudu_Tudu $tudu
     */
    public function createFlow(Model_Tudu_Extension_Flow $flow)
    {
        /* @var $daoFlow Dao_Td_Tudu_Flow */
        $daoFlow = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Flow', Tudu_Dao_Manager::DB_TS);

        if (!$daoFlow->createFlow($flow->toArray())) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Tudu flow save failed', Model_Tudu_Exception::SAVE_FAILED);
        }
    }

}