CREATE TABLE IF NOT EXISTS `users`
(
  `user_id`  INT         NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(40) NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  `type`     INT         NOT NULL,
  `email`    VARCHAR(90) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `subjects`
(
  `subject_id`   INT                                                    NOT NULL AUTO_INCREMENT,
  `subject_name` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE = InnoDB;