<?php
/**
 * Tudu Library
 *
 * LICENSE
 *
 *
 * @category   Model
 * @package    Model_Tudu
 * @copyright  Copyright (c) 2009-2012 Shanghai Best Oray Information S&T CO., Ltd.
 * @link       http://www.oray.com/
 * @version    $Id$
 */

/**
 * @see Model_Tudu_Compose_Abstract
 */
require_once 'Model/Tudu/Compose/Abstract.php';

/**
 * @see Tudu_Dao_Manager
 */
require_once 'Tudu/Dao/Manager.php';

/**
 * @category   Model
 * @package    Model_Tudu
 * @copyright  Copyright (c) 2009-2012 Shanghai Best Oray Information S&T CO., Ltd.
 */
class Model_Tudu_Compose_Review extends Model_Tudu_Compose_Abstract
{
    /**
     * 当前操作人是否允许在转发时修改图度内容
     *
     * @var boolean
     */
    protected $_isModified = true;

    /**
     * 过滤审批条件
     * 1.必须是图度当前步骤的审批人
     *
     * @see Model_Tudu_Compose_Abstract::filter()
     */
    public function filter(Model_Tudu_Tudu &$tudu)
    {
        if (!$tudu->tuduId) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Tudu not exists', Model_Tudu_Exception::TUDU_NOTEXISTS);
        }

        /* @var $daoTudu Dao_Td_Tudu_Tudu */
        $daoTudu = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Tudu', Tudu_Dao_Manager::DB_TS);
        $this->_fromTudu = $daoTudu->getTuduById($this->_user->uniqueId, $tudu->tuduId);

        if (!$this->_fromTudu->stepId || false !== strpos('^', $this->_fromTudu->stepId)) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Not allow to review tudu', Model_Tudu_Exception::PERMISSION_DENIED);
        }

        /* @var $daoStep Dao_Td_Tudu_Step */
        $daoStep = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Step', Tudu_Dao_Manager::DB_TS);

        $reviewers = $daoStep->getUsers($this->_fromTudu->tuduId, $this->_fromTudu->stepId, $this->_user->uniqueId);

        if (!isset($reviewers[$this->_user->uniqueId]) || /*$reviewer['type'] != Dao_Td_Tudu_Step::TYPE_EXAMINE ||*/ $reviewers[$this->_user->uniqueId]['status'] != 1) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Not allow to review tudu', Model_Tudu_Exception::PERMISSION_DENIED);
        }

        // 暂时不能输入自己 - 界面交互有问题不能支持
        if ($tudu->reviewer &&  (array_key_exists($this->_user->address, $tudu->reviewer)
            || array_key_exists($this->_user->userName, $tudu->reviewer)))
        {
            require_once '/Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Could not add youself to reviewer', Model_Tudu_Exception::PERMISSION_DENIED);
        }

        // 过滤没有更新字段
        if ($tudu->acceptMode == $this->_fromTudu->acceptMode) {
            $tudu->acceptMode = null;
        }

        if ($tudu->to) {
            $isChange = false;
            foreach ($tudu->to as $item) {
                if (!array_key_exists($item['email'], $this->_fromTudu->to)) {
                    $isChange = true;
                    break;
                }
            }

            $isChange = $isChange && count($tudu->to) == count($this->_fromTudu->to);

            if (!$isChange) {
                $tudu->to = null;
            }
        }

        $cc  = $tudu->cc;
        $bcc = $tudu->bcc;
        if ($this->_fromTudu->cc) {
            foreach ($this->_fromTudu->cc as $item) {
                if (false !== strpos($item[3], '@')) {
                    $u = array(
                        'truename' => $item[0],
                        'username' => $item[3]
                    );
                } else {
                    $u = array(
                        'groupname' => $item[0],
                        'truename'  => $item[0],
                        'groupid'   => $item[3]
                    );
                }

                $cc[] = $u;
            }
            $tudu->cc = $cc;
        }

        if ($this->_fromTudu->bcc) {
            foreach ($this->_fromTudu->bcc as $item) {
                if (false !== strpos($item[3], '@')) {
                    $cc = array(
                        'truename' => $item[0],
                        'username' => $item[3]
                    );
                } else {
                    $cc = array(
                        'truename'  => $item[0],
                        'groupname' => $item[0],
                        'groupid'   => $item[3]
                    );
                }

                $bcc[] = $cc;
            }
            $tudu->bcc = $bcc;
        }

        $tudu->stepId = $this->_fromTudu->stepId;
        $tudu->type   = $this->_fromTudu->type;
        $tudu->from   = $this->_fromTudu->from;
        $tudu->fromTudu = $this->_fromTudu;
        $tudu->flowId = $this->_fromTudu->flowId;
    }

    /**
     * (non-PHPdoc)
     * @see Model_Tudu_Compose_Abstract::compose()
     */
    public function compose(Model_Tudu_Tudu &$tudu)
    {

        require_once 'Model/Tudu/Flow.php';
        /* @var $flow Model_Tudu_Flow */
        $flow = new Model_Tudu_Flow();

        if ($tudu->isAgree) {
            $flow->agree($tudu);
        } else {
            $flow->disagree($tudu);
        }

        // 发送回复
        /* @var $daoPost Dao_Td_Tudu_Post */
        $daoPost = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Post', Tudu_Dao_Manager::DB_TS);
        /* @var $daoTudu Dao_Td_Tudu_Post */
        $daoTudu = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Tudu', Tudu_Dao_Manager::DB_TS);
        /* @var $daoFile Dao_Td_Attachment_File */
        $daoFile = Tudu_Dao_Manager::getDao('Dao_Td_Attachment_File', Tudu_Dao_Manager::DB_TS);

        $header = array(
            'action'         => 'review',
            'tudu-act-value' => $tudu->isAgree ? 1 : 0,
        );

        if ($this->_fromTudu->type != 'notice') {
            $headerKey = $tudu->reviewer ? 'tudu-reviewer' : 'tudu-to';
            $items     = $tudu->reviewer ? array_shift($tudu->reviewer) : $tudu->to;

            $val = array();
            foreach ($items as $item) {
                $val[] = $item['truename'];
            }
            $header[$headerKey] = implode(',', $val);
        }

        if ($tudu->header) {
            $header = array_merge($tudu->header, $header);
        }

        $postParams = array(
            'orgid'      => $this->_fromTudu->orgId,
            'tuduid'     => $this->_fromTudu->tuduId,
            'boardid'    => $this->_fromTudu->boardId,
            'uniqueid'   => $this->_user->uniqueId,
            'postid'     => Dao_Td_Tudu_Post::getPostId($this->_fromTudu->tuduId),
            'poster'     => $this->_user->trueName,
            'email'      => $this->_user->userName,
            'header'     => $header,
            'content'    => $tudu->content,
            'createtime' => time()
        );

        $postId = $daoPost->createPost($postParams);
        $daoPost->sendPost($tudu->tuduId, $postId);

        $attachments = $tudu->getAttachments();
        foreach ($attachments as $id => $attach) {
            $daoFile->addPost($tudu->tuduId, $postId, $attach['attachid'], $attach['isattachment']);
        }

        $attrs   = $tudu->getStorageParams();
        $tuduParams = array(
            'stepid' => $attrs['stepid']
        );
        if (!empty($attrs['to'])) {
            $tuduParams['to'] = $attrs['to'];
        }
        $daoTudu->updateTudu($tudu->tuduId, $tuduParams);

        $this->_tuduLog('review', $tudu);
    }

    /**
     * (non-PHPdoc)
     * @see Model_Tudu_Compose_Abstract::send()
     */
    public function send(Model_Tudu_Tudu &$tudu)
    {
        /* @var $daoTudu Dao_Td_Tudu_Tudu */
        $daoTudu = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Tudu', Tudu_Dao_Manager::DB_TS);
        /* @var $daoTuduGroup Dao_Td_Tudu_Group */
        $daoTuduGroup = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Group', Tudu_Dao_Manager::DB_TS);

        $user    = Tudu_User::getInstance();

        $recipients = $this->_getRecipients($tudu);

        // 发送图度
        $to = $tudu->to;

        $daoTudu->deleteLabel($tudu->tuduId, $this->_user->uniqueId, '^e');
        // 添加已审批
        $daoTudu->addLabel($tudu->tuduId, $this->_user->uniqueId, '^v');

        if ($tudu->type == 'task' && !$tudu->reviewer && !$tudu->isDraft) {
            // 移除原有执行人
            $accepters = $daoTudu->getAccepters($tudu->tuduId);

            foreach ($accepters as $item) {
                list($username, ) = explode(' ', $item['accepterinfo'], 2);
                // 修改用户关联记录为非执行人，移除“我执行”标签
                if (!empty($to) && array_key_exists($username, $to) && $daoTuduGroup->getChildrenCount($tudu->tuduId, $item['uniqueid']) <= 0) {
                    $daoTudu->removeAccepter($tudu->tuduId, $item['uniqueid']);
                    $daoTudu->deleteLabel($tudu->tuduId, $item['uniqueid'], '^a');
                }
            }
        }

        // 处理发送
        foreach ($recipients as $uniqueId => $recipient) {
            // 跳过已发送的外发执行人
            if (!empty($recipient['isforeign']) && !empty($to) && array_key_exists($recipient['email'], $to)) {
                continue ;
            }

            if (!empty($recipient['isforeign'])) {
                $recipient['authcode'] = $tudu->isAuth ? Oray_Function::randKeys(4) : null;
            }

            if ($tudu->flowId && isset($recipient['role']) && $recipient['role'] == 'to') {
                $recipients[$key]['tudustatus'] = 1;
                $recipients[$key]['percent']    = 0;
            }
        }

        // 执行发送
        $this->_sendTudu($tudu, $recipients);

        $daoTudu->markAllUnread($tudu->tuduId);
        $daoTudu->markRead($tudu->tuduId, $this->_user->uniqueId, true);
    }
}