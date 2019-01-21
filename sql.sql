CREATE TABLE IF NOT EXISTS `users`
(
  `user_id`  INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(40) NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  `type`     INT NOT NULL,
  `email`    VARCHAR(90) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE = InnoDB;