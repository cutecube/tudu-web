CREATE TABLE `td_tudu_step` (
  `org_id` varchar(60) NOT NULL DEFAULT '' COMMENT '组织ID',
  `tudu_id` varchar(36) NOT NULL DEFAULT '' COMMENT '图度ID',
  `unique_id` varchar(36) NOT NULL DEFAULT '' COMMENT '创建人ID',
  `step_id` varchar(36) NOT NULL DEFAULT '0' COMMENT '步骤ID',
  `prev_step_id` varchar(36) DEFAULT NULL COMMENT '前一步骤ID',
  `next_step_id` varchar(36) DEFAULT NULL COMMENT '下一步骤ID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '步骤类型 0.执行，1.审批',
  `step_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '步骤状态 0.未进行,1.进行中, 2.已完成,3.已经拒绝（不同意）,4.作废',
  `is_done` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已完成',
  `is_current` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否当前执行步骤',
  `is_show` tinyint(1) unsigned DEFAULT NULL COMMENT '是否在步骤列表中显示',
  `percent` tinyint(3) unsigned DEFAULT NULL COMMENT '完成率',
  `order_num` int(11) unsigned DEFAULT NULL COMMENT '次序ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`tudu_id`,`step_id`),
  KEY `idx_org_id` (`org_id`),
  KEY `idx_is_current` (`is_current`),
  KEY `idx_type` (`type`),
  KEY `idx_prev_step_id` (`prev_step_id`),
  KEY `idx_next_step_id` (`next_step_id`),
  CONSTRAINT `step_of_which_tudu` FOREIGN KEY (`tudu_id`) REFERENCES `td_tudu` (`tudu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='图度步骤记录表';



-- Table "td_tudu_step_user" DDL

CREATE TABLE `td_tudu_step_user` (
  `tudu_id` varchar(36) NOT NULL DEFAULT '' COMMENT '图度ID',
  `step_id` varchar(35) NOT NULL DEFAULT '' COMMENT '步骤ID',
  `unique_id` varchar(36) NOT NULL DEFAULT '' COMMENT '用户唯一ID',
  `user_info` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '用户信息 email name',
  `process_index` int(11) NOT NULL DEFAULT '0' COMMENT '处理顺序索引',
  `percent` tinyint(3) DEFAULT NULL COMMENT '进度',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '跟进状态，与td_tudu.status一致',
  `temp_is_done` tinyint(1) NOT NULL DEFAULT '0' COMMENT '数据过渡是否完成',
  PRIMARY KEY (`tudu_id`,`step_id`,`unique_id`),
  KEY `idx_tudu_id` (`tudu_id`),
  KEY `idx_process_index` (`process_index`),
  KEY `idx_status` (`status`),
  KEY `idx_temp_is_done` (`temp_is_done`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='步骤执行人关联';
