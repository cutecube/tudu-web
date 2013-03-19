<?php
/**
 * Tudu Library
 *
 * LICENSE
 *
 *
 * @category   Model
 * @package    Model_Tudu
 * @copyright  Copyright (c) 2009-2010 Shanghai Best Oray Information S&T CO., Ltd.
 * @link       http://www.oray.com/
 * @version    $Id$
 */

/**
 * @see Tudu_User
 */
require_once 'Tudu/User.php';

/**
 * @category   Model
 * @package    Model_Tudu
 * @copyright  Copyright (c) 2009-2010 Shanghai Best Oray Information S&T CO., Ltd.
 */
abstract class Model_Tudu_Compose_Abstract extends Model_Abstract
{
    /**
     *
     * @var mixed
     */
    protected $_fromTudu = null;

    /**
     *
     * @var Tudu_User
     */
    protected $_user = null;

    /**
     *
     * @var int
     */
    protected $_time = null;

    /**
     *
     * @var array
     */
    protected $_boards = array();

    /**
     *
     * @var Model_Tudu_Flow
     */
    protected $_flow = null;

    /**
     *
     */
    public function __construct()
    {
        $this->_time = time();

        $this->addFilter('compose', array($this, 'filter'), Model_Abstract::HOOK_WEIGHT_MAX);
        $this->addAction('compose', array($this, 'send'), 1);

        /* @var $user Tudu_User */
        $this->_user = Tudu_User::getInstance();

        // 缺少身份认证的用户
        if (!$this->_user->isLogined()) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Invalid user to execute current operation', Model_Tudu_Exception::INVALID_USER);
        }
    }

    /**
     * 图度参数过滤
     *
     * @param Model_Tudu_Tudu $tudu
     */
    abstract public function filter(Model_Tudu_Tudu &$tudu) ;

    /**
     * 发送操作
     *
     * @param Model_Tudu_Tudu $tudu
     * @throws Model_Tudu_Exception
     */
    abstract public function compose(Model_Tudu_Tudu &$tudu) ;

    /**
     * 发送图度
     *
     * @param Model_Tudu_Tudu $tudu
     * @throws Model_Tudu_Exception
     */
    abstract public function send(Model_Tudu_Tudu &$tudu) ;

    /**
     *
     * @param Model_Tudu_Tudu $tudu
     * @throws Model_Tudu_Exception
     */
    protected function _createTudu(Model_Tudu_Tudu &$tudu)
    {
        /* @var $daoTudu Dao_Td_Tudu_Tudu */
        $daoTudu = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Tudu', Tudu_Dao_Manager::DB_TS);
        /* @var $daoPost Dao_Td_Tudu_Post */
        $daoPost = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Post', Tudu_Dao_Manager::DB_TS);
        /* @var $daoAttach Dao_Td_Attachment_File */
        $daoAttach = Tudu_Dao_Manager::getDao('Dao_Td_Attachment_File', Tudu_Dao_Manager::DB_TS);
        /* @var $daoFile Dao_Td_Netdisk_File */
        $daoFile = Tudu_Dao_Manager::getDao('Dao_Td_Netdisk_File', Tudu_Dao_Manager::DB_TS);

        if (!$tudu->tuduId) {
            $tudu->tuduId = Dao_Td_Tudu_Tudu::getTuduId();
        }

        if (!$tudu->postId) {
            $tudu->postId = Dao_Td_Tudu_Post::getPostId($tudu->tuduId);
        }

        $params = $tudu->getStorageParams();

        $attachments = $tudu->getAttachments();

        // 处理网盘附件
        $attachNum = 0;
        foreach ($attachments as $k => $attach) {
            if ($attach['isnetdisk']) {
                $fileId = $attach['fileid'];
                if (null !== $daoAttach->getFile(array('fileid' => $fileId))) {
                    $ret['attachment'][] = $fileId;
                    continue ;
                }

                $file = $daoFile->getFile(array('uniqueid' => $this->_user->uniqueId, 'fileid' => $fileId));

                if (null === $file) {
                    continue ;
                }

                $fileId = $file->fromFileId ? $file->fromFileId : $file->attachFileId;

                $ret = $daoAttach->createFile(array(
                    'uniqueid' => $this->_user->uniqueId,
                    'fileid'   => $fileId,
                    'orgid'    => $this->_user->orgId,
                    'filename' => $file->fileName,
                    'path'     => $file->path,
                    'type'     => $file->type,
                    'size'     => $file->size,
                    'createtime' => $this->_time
                ));

                if ($ret) {
                    $attachments[$k]['fileid'] = $fileId;
                } else {
                    unset($attachments[$k]);
                }
            }

            if ($attach['isattach']) {
                $attachNum ++;
            }
        }

        $params['attachnum'] = $attachNum;
        $params['isfirst']   = 1;

        $tuduId = $daoTudu->createTudu($params);

        if (!$tuduId) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Tudu save failed', Model_Tudu_Exception::SAVE_FAILED);
        }

        $params['issend'] = 1;
        $postId = $daoPost->createPost($params);
        if (!$postId) {
            $daoTudu->deleteTudu($tuduId);

            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Tudu content save failed', Model_Tudu_Exception::SAVE_FAILED);
        }

        $tudu->postId = $postId;

        if ($tudu->type == 'meeting') {
            /* @var $daoMeeting Dao_Md_Tudu_Meeting */
            $daoMeeting = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Meeting', Tudu_Dao_Manager::DB_TS);

            $daoMeeting->createMeeting(array(
                'orgid'  => $tudu->orgId,
                'tuduid' => $tudu->tuduId,
                'location' => $tudu->location,
                'notifytype' => $tudu->notifyType,
                'notifytime' => $tudu->notifyTime,
                'isallday'   => $tudu->isAllDay
            ));
        }

        foreach ($attachments as $attach) {
            $daoAttach->addPost($tuduId, $postId, $attach['fileid'], (boolean) $attach['isattach']);
        }
    }

    /**
     *
     * @param Model_Tudu_Tudu $tudu
     * @throws Model_Tudu_Exception
     */
    protected function _updateTudu(Model_Tudu_Tudu &$tudu, $updates = null)
    {
        /* @var $daoTudu Dao_Td_Tudu_Tudu */
        $daoTudu = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Tudu', Tudu_Dao_Manager::DB_TS);
        /* @var $daoPost Dao_Td_Post_Post */
        $daoPost = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Post', Tudu_Dao_Manager::DB_TS);
        /* @var $daoAttach Dao_Td_Attachment_File */
        $daoAttach = Tudu_Dao_Manager::getDao('Dao_Td_Attachment_File', Tudu_Dao_Manager::DB_TS);
        /* @var $daoFile Dao_Td_Netdisk_File */
        $daoFile = Tudu_Dao_Manager::getDao('Dao_Td_Netdisk_File', Tudu_Dao_Manager::DB_TS);

        $params = $tudu->getStorageParams();

        $attachments = $tudu->getAttachments();

        // 处理网盘附件
        $attachNum = 0;
        foreach ($attachments as $k => $attach) {
            if ($attach['isnetdisk']) {
                $fileId = $attach['fileid'];
                if (null !== $daoAttach->getFile(array('fileid' => $fileId))) {
                    $ret['attachment'][] = $fileId;
                    continue ;
                }

                $file = $daoFile->getFile(array('uniqueid' => $this->_user->uniqueId, 'fileid' => $fileId));

                if (null === $file) {
                    continue ;
                }

                $fileId = $file->fromFileId ? $file->fromFileId : $file->attachFileId;

                $ret = $daoAttach->createFile(array(
                    'uniqueid' => $this->_user->uniqueId,
                    'fileid'   => $fileId,
                    'orgid'    => $this->_user->orgId,
                    'filename' => $file->fileName,
                    'path'     => $file->path,
                    'type'     => $file->type,
                    'size'     => $file->size,
                    'createtime' => $this->_time
                ));

                if ($ret) {
                    $attachments[$k]['fileid'] = $fileId;
                } else {
                    unset($attachments[$k]);
                }
            }

            if ($attach['isattach']) {
                $attachNum ++;
            }
        }

        $params['attachnum'] = $attachNum;

        if (!$daoTudu->updateTudu($tudu->tuduId, $params)) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Tudu save failed', Model_Tudu_Exception::SAVE_FAILED);
        }

        if (!$daoPost->updatePost($tudu->tuduId, $tudu->postId, $params)) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Tudu content save failed', Model_Tudu_Exception::SAVE_FAILED);
        }

        if ($tudu->type == 'meeting') {
            /* @var $daoMeeting Dao_Md_Tudu_Meeting */
            $daoMeeting = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Meeting', Tudu_Dao_Manager::DB_TS);

            $params = array(
                'location'   => $tudu->location,
                'notifytype' => $tudu->notifyType,
                'notifytime' => $tudu->notifyTime,
                'isallday'   => $tudu->isAllDay
            );

            if ($daoMeeting->existsMeeting($tudu->tuduId)) {
                $params['tuduid'] = $tudu->tuduId;
                $params['orgid']  = $tudu->orgId;
                $daoMeeting->createMeeting($params);
            } else {
                $daoMeeting->updateMeeting($tudu->tuduId, $params);
            }
        }

        // 添加附件关联
        $daoAttach->deletePost($tudu->tuduId, $tudu->postId);
        foreach ($attachments as $attach) {
            $daoAttach->addPost($tudu->tuduId, $tudu->postId, $attach['fileid'], (boolean) $attach['isattach']);
        }
    }

    /**
     * 发送图度
     */
    protected function _sendTudu(Model_Tudu_Tudu &$tudu, array $recipients)
    {
        /* @var $daoTudu Dao_Td_Tudu_Tudu */
        $daoTudu = Tudu_Dao_Manager::getDao('Dao_Td_Tudu_Tudu', Tudu_Dao_Manager::DB_TS);

        $isAccepted = false;
        foreach ($recipients as $unId => $recipient) {
            if (!isset($recipient['accepterinfo']) && isset($recipient['email']) && isset($recipient['truename'])) {
                $recipient['accepterinfo'] = $recipient['email'] . ' ' . $recipient['truename'];
            }

            $params = $recipient;

            if (array_key_exists('percent', $params) || (!empty($params['role']) && $params['role'] == 'to')) {
                $params['percent'] = isset($params['percent']) ? (int) $params['percent'] : 0;
            }

            $labels = $daoTudu->addUser($tudu->tuduId, $recipient['uniqueid'], $params);

            if (false !== $labels) {
                if (is_string($labels) && !empty($recipient)) {
                    $daoTudu->updateTuduUser($tudu->tuduId, $recipient['uniqueid'], $params);
                }

                if (!empty($recipient['role']) && $recipient['role'] === 'to') {
                    $to[] = $unId;
                }

                if (is_string($labels)) {
                    $labels = explode(',', $labels);
                } else {
                    $labels = array();
                }

                // 所有图度标签
                if (!in_array('^all', $labels)) {
                    $daoTudu->addLabel($tudu->tuduId, $recipient['uniqueid'], '^all');
                }

                // 图度箱
                if (!in_array('^i', $labels) && !in_array('^g', $labels)) {
                    $daoTudu->addLabel($tudu->tuduId, $recipient['uniqueid'], '^i');
                }

                // 我执行
                if (!empty($recipient['role']) && $recipient['role'] === 'to' && !in_array('^a', $labels) && $tudu->type == 'task') {
                    $daoTudu->addLabel($tudu->tuduId, $recipient['uniqueid'], '^a');

                    if ($tudu->flowId || $tudu->uniqueId == $recipient['uniqueid']) {
                        $isAccepted = true;
                        // 更新最后接受时间
                        $daoTudu->updateTuduUser($tudu->tuduId, $unId, array('tudustatus' => 1, 'accepttime' => $this->_time));
                    }
                }

                // 已发送
                if ($tudu->uniqueId == $recipient['uniqueid'] && !in_array('^f', $labels)) {
                    $daoTudu->addLabel($tudu->tuduId, $recipient['uniqueid'], '^f');
                }

                // 审批
                if (!empty($recipient['isreview']) && !in_array('^e', $labels)) {
                    $daoTudu->addLabel($tudu->tuduId, $recipient['uniqueid'], '^e');
                }

                if ($tudu->type == 'notice' && !in_array('^n', $labels)) {
                    $daoTudu->addLabel($tudu->tuduId, $recipient['uniqueid'], '^n');
                }

                if ($tudu->type == 'discuss' && !in_array('^d', $labels)) {
                    $daoTudu->addLabel($tudu->tuduId, $recipient['uniqueid'], '^d');
                }

                if ($tudu->type == 'meeting' && !in_array('^m', $labels)) {
                    $daoTudu->addLabel($tudu->tuduId, $recipient['uniqueid'], '^m');
                }

                if (isset($this->_typeLabels[$tudu->type])) {
                    $labelId = $this->_typeLabels[$tudu->type];
                    if (!in_array($labelId, $labels)) {
                        $daoTudu->addLabel($tudu->tuduId, $recipient['uniqueid'], $labelId);
                    }
                }
            }
        }

        if ($tudu->type == 'task') {
            if ($isAccepted) {
                $daoTudu->updateLastAcceptTime($tudu->tuduId);
            } else {
                foreach ($recipients as $unId => $u) {
                    if (!empty($u['role'])) {
                        $daoTudu->addLabel($tudu->tuduId, $unId, '^td');
                    }
                }
            }
        }

        if (!$daoTudu->sendTudu($tudu->tuduId)) {
            require_once 'Model/Tudu/Exception.php';
            throw new Model_Tudu_Exception('Tudu send failed', Model_Tudu_Exception::SAVE_FAILED);
        }
    }

    /**
     *
     * @return array
     */
    protected function _getBoards()
    {
        if (empty($this->_boards)) {
            /* @var $daoBoard Dao_Td_Board_Board */
            $daoBoard = Tudu_Dao_Manager::getDao('Dao_Td_Board_Board', Tudu_Dao_Manager::DB_TS);

            $this->_boards = $daoBoard->getBoards(array('orgid' => $this->_user->orgId))->toArray('boardid');
        }

        return $this->_boards;
    }

    /**
     * 记录图度日志
     * @param Model_Tudu_Tudu $tudu
     */
    protected function _tuduLog($action, Model_Tudu_Tudu $tudu)
    {
        $detail = $this->_getLogDetail($tudu);
        $detail = serialize($detail);

        $daoLog = Tudu_Dao_Manager::getDao('Dao_Td_Log_Log', Tudu_Dao_Manager::DB_TS);
        return $daoLog->createLog(array(
            'orgid'      => $this->_user->orgId,
            'uniqueid'   => $this->_user->uniqueId,
            'operator'   => $this->_user->userName . ' ' . $this->_user->trueName,
            'logtime'    => time(),
            'targettype' => 'tudu',
            'targetid'   => $tudu->tuduId,
            'action'     => $action,
            'detail'     => $detail,
            'privacy'    => 0
        ));
    }

    /**
     *
     * @param Model_Tudu_Tudu $tudu
     */
    protected function _getLogDetail(Model_Tudu_Tudu $tudu)
    {
        $detail = array();
        $params = $tudu->getStorageParams();

        if (!$this->_fromTudu || $this->_fromTudu->isDraft) {
            foreach ($params as $key => $value) {
                if (!empty($value)) {
                    $detail[$key] = $value;
                }
            }

            return $detail;
        }

        $excepts = array('attach', 'uniqueid', 'status', 'poster', 'posterinfo', 'lastposter', 'issend');

        $tudu = $this->_fromTudu->toArray();
        $ret  = array();
        foreach ($params as $key => $val) {
            if (in_array($key, $excepts) || empty($val)) {
                continue ;
            }

            if ($key == 'to') {
                if (count($params[$key]) != count($tudu['accepter'])) {
                    $val = Tudu_Tudu_Storage::formatReceiver($params[$key]);
                } else {
                    if (is_array($params[$key])) {
                        foreach ($params[$key] as $k => $val) {
                            if (!in_array($k, $tudu['accepter'])) {
                                $val = Tudu_Tudu_Storage::formatReceiver($params[$key]);
                            }
                        }
                    }
                }
                continue ;
            }

            if ($key == 'cc' || $key == 'bcc'/* || $key == 'reviewer'*/) {
                $val = Tudu_Tudu_Storage::formatReceiver($params[$key]);
            }

            if (array_key_exists($key, $tudu) && $params[$key] != $tudu[$key]) {
                $detail[$key] = $val;
            }
        }

        return $detail;
    }

    /**
     * 付哦去图度发送人列表
     *
     * @param Model_Tudu_Tudu $tudu
     * @return array
     */
    protected function _getRecipients(Model_Tudu_Tudu &$tudu)
    {
        $uniqueId = $this->_user->uniqueId;
        $orgId    = $this->_user->orgId;

        require_once 'Tudu/AddressBook.php';
        /* @var $addressBook Tudu_AddressBook */
        $addressBook = Tudu_AddressBook::getInstance();

        $recipients = array();
        if ($tudu->reviewer) {
            foreach ($tudu->reviewer as $key => $reviewers) {

                foreach ($reviewers as $item) {
                    $user = $addressBook->searchUser($orgId, $item['email']);
                    if (null === $user) {
                        $user = $addressBook->searchContact($uniqueId, $item['email'], $item['truename']);

                        if (null === $user) {
                            $user = $addressBook->prepareContact($item['email'], $item['truename']);
                        }
                    }

                    $user['accepterinfo'] = $user['email'] . ' ' . $user['truename'];
                    $user['isreview']     = true;

                    $recipients[$user['uniqueid']] = $user;
                }
                // 顺序取首个
                break;
            }

            // 接收人
        } elseif ($tudu->to) {
            foreach ($tudu->to as $key => $item) {
                if (isset($item['groupid']) && $tudu->type == 'meeting') {

                    if (0 === strpos($item['groupid'], 'XG')) {
                        $users = $addressBook->getGroupContacts($orgId, $uniqueId, $item['groupid']);
                    } else {
                        $users = $addressBook->getGroupUsers($orgId, $item['groupid']);
                    }

                    $to = array();
                    foreach ($users as $key => $user) {
                        $users[$key]['role']         = 'to';
                        $users[$key]['accepterinfo'] = $users[$key]['email'] . ' ' . $users[$key]['truename'];
                        $users[$key]['issender']     = $users[$key]['email'] == $tudu->sender;

                        $to[] = $users[$key]['accepterinfo'];

                        $recipients[$key] = $users[$key];
                    }

                    $tudu->to = implode("\n", $to);
                } else {
                    $user = $addressBook->searchUser($orgId, $item['email']);

                    if (null === $user) {
                        $user = $addressBook->searchContact($uniqueId, $item['email'], $item['truename']);

                        if (null === $user) {
                            $user = $addressBook->prepareContact($item['email'], $item['truename']);
                        }
                    }

                    $user['role']         = 'to';
                    $user['accepterinfo'] = $user['email'] . ' ' . $user['truename'];
                    $user['issender']     = $item['email'] == $tudu->sender;

                    if (isset($item['percent'])) {
                        $user['percent'] = (int) $item['percent'];
                    }

                    $percent            = isset($item['percent']) ? (int) $item['percent'] : 0;
                    $user['tudustatus'] = $percent >= 100 ? 2 : ($percent == 0 ? 0 : 1);

                    $recipients[$user['uniqueid']] = $user;
                }
            }
        }

        if ($tudu->type == 'notice' && $tudu->reviewer) {
            return ;
        }

        if ($tudu->cc) {

            foreach ($tudu->cc as $key => $item) {
                if (isset($item['groupid'])) {

                    if (0 === strpos($item['groupid'], 'XG')) {
                        $users = $addressBook->getGroupContacts($orgId, $uniqueId, $item['groupid']);
                    } else {
                        $users = $addressBook->getGroupUsers($orgId, $item['groupid']);
                    }

                    $recipients = array_merge($users, $recipients);

                } else {
                    $user = $addressBook->searchUser($orgId, $item['email']);

                    if (null === $user) {
                        $user = $addressBook->searchContact($uniqueId, $item['email'], $item['truename']);

                        if (null === $user) {
                            $user = $addressBook->prepareContact($item['email'], $item['truename']);
                        }
                    }

                    if (!isset($recipients[$user['uniqueid']])) {
                        $recipients[$user['uniqueid']] = $user;
                    }
                }
            }
        }

        if ($tudu->bcc) {
            foreach ($tudu->bcc as $key => $item) {
                if (isset($item['groupid'])) {

                    if (0 === strpos($item['groupid'], 'XG')) {
                        $users = $addressBook->getGroupContacts($orgId, $uniqueId, $item['groupid']);
                    } else {
                        $users = $addressBook->getGroupUsers($orgId, $item['groupid']);
                    }

                    $recipients = array_merge($users, $recipients);

                } else {
                    $user = $addressBook->searchUser($orgId, $item['email']);

                    if (null === $user) {
                        $user = $addressBook->searchContact($uniqueId, $item['email'], $item['truename']);

                        if (null === $user) {
                            $user = $addressBook->prepareContact($item['email'], $item['truename']);
                        }
                    }

                    if (!isset($recipients[$user['uniqueid']])) {
                        $recipients[$user['uniqueid']] = $user;
                    }
                }
            }
        }

        return $recipients;
    }
}