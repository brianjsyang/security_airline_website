CREATE TABLE `abc_airline`.`users` ( 
    `uid` INT(10) NOT NULL , 
    `username` VARCHAR(255) NOT NULL , 
    `user_pw` VARCHAR(255) NOT NULL , 
    `email` VARCHAR(255) NOT NULL , 
    `branch_id` INT NOT NULL , 
    PRIMARY KEY (`uid`)
) ENGINE = InnoDB;

CREATE TABLE `abc_airline`.`branch` ( 
    `branch_id` INT NOT NULL , 
    `branch_name` VARCHAR(255) NOT NULL , 
    PRIMARY KEY (`branch_id`)
) ENGINE = InnoDB;

CREATE TABLE `abc_airline`.`pub_key` ( `uid` INT NOT NULL , `pub_key` VARCHAR(1500) NOT NULL , PRIMARY KEY (`uid`)) ENGINE = InnoDB;
CREATE TABLE `abc_airline`.`message` ( `mid` INT NOT NULL AUTO_INCREMENT , `ruid` INT NOT NULL , `message` VARCHAR(10000) NOT NULL , `suid` INT NOT NULL , PRIMARY KEY (`mid`)) ENGINE = InnoDB;
CREATE TABLE `abc_airline`.`ac_maint` ( `aid` VARCHAR(20) NOT NULL , `amodel` VARCHAR(20) NOT NULL , `prev_maint` DATE NOT NULL , `next_maint` DATE NOT NULL , `permission` INT NOT NULL , PRIMARY KEY (`aid`)) ENGINE = InnoDB;



ALTER TABLE `users` ADD CONSTRAINT `fk_branch_id` FOREIGN KEY (`branch_id`) REFERENCES `branch`(`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `users` ADD UNIQUE( `username`);
ALTER TABLE `users` CHANGE `uid` `uid` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ac_maint` ADD CONSTRAINT `fk_permission` FOREIGN KEY (`permission`) REFERENCES `branch`(`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `message` ADD CONSTRAINT `fk_ruid` FOREIGN KEY (`ruid`) REFERENCES `users`(`uid`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `message` ADD CONSTRAINT `fk_suid` FOREIGN KEY (`suid`) REFERENCES `users`(`uid`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `pub_key` ADD CONSTRAINT `fk_uid` FOREIGN KEY (`uid`) REFERENCES `users`(`uid`) ON DELETE CASCADE ON UPDATE CASCADE;
