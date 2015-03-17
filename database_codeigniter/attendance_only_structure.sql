CREATE TABLE IF NOT EXISTS `course` (
  `course_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `course_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `optional_course` enum('n','y') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
