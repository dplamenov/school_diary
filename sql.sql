CREATE TABLE IF NOT EXISTS `users`
(
  `user_id`  INT         NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(40) NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  `type`     INT         NOT NULL,
  `email`    VARCHAR(90) NOT NULL,
  `id`       INT         NOT NULL,
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
   PRIMARY KEY(`student_id`)
) ENGINE = InnoDB;