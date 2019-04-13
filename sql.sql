CREATE TABLE IF NOT EXISTS `users`
(
  `user_id`            INT         NOT NULL AUTO_INCREMENT,
  `username`           VARCHAR(40) NOT NULL,
  `password`           VARCHAR(64) NOT NULL,
  `type`               INT         NOT NULL,
  `email`              VARCHAR(90) NOT NULL,
  `id`                 INT         NOT NULL,
  `is_password_change` TINYINT     NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `subjects`
(
  `subject_id`   INT                                                    NOT NULL AUTO_INCREMENT,
  `subject_name` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `teachers`
(
  `teacher_id`   INT                                                     NOT NULL AUTO_INCREMENT,
  `teacher_name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `teacher_subject`
(
  `teacher_id` INT NOT NULL,
  `subject_id` INT NOT NULL
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `classes`
(
  `class_id`   INT         NOT NULL AUTO_INCREMENT,
  `class_name` VARCHAR(15) NOT NULL,
  `count`      INT         NOT NULL,
  `teacher`    INT         NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `teacher_classes`
(
  `class_id`   INT NOT NULL,
  `teacher_id` INT NOT NULL,
  `subject_id` INT NOT NULL
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `students`
(
  `student_id`   INT         NOT NULL AUTO_INCREMENT,
  `student_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `students_classes`
(
  `class_id`   INT NOT NULL,
  `student_id` INT NOT NULL
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `parents`
(
  `parent_id`   INT                                                    NOT NULL AUTO_INCREMENT,
  `parent_name` VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `student_id`  INT                                                    NOT NULL,
  PRIMARY KEY (`parent_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `grades`
(
  `grade_id`   INT     NOT NULL AUTO_INCREMENT,
  `student_id` INT     NOT NULL,
  `subject_id` INT     NOT NULL,
  `teacher_id` INT     NOT NULL,
  `grade`      INT     NOT NULL,
  `signed`     TINYINT NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `notes`
(
  `note_id`    INT         NOT NULL AUTO_INCREMENT,
  `student_id` INT         NOT NULL,
  `teacher_id` INT         NOT NULL,
  `note`       VARCHAR(70) NOT NULL,
  `signed`     TINYINT     NOT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `grade`
(
  `grade_id`     INT         NOT NULL AUTO_INCREMENT,
  `grade_name`   VARCHAR(15) NOT NULL,
  `grade_number` INT         NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `config`
(
  `id`    INT         NOT NULL,
  `_key`  VARCHAR(30) NOT NULL,
  `value` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;