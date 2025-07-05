CREATE TABLE `user` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `mobile` VARCHAR(15) NOT NULL,
    `address` TEXT NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `photo` VARCHAR(255) NOT NULL,
    `role` ENUM('1', '2') NOT NULL DEFAULT '1',
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `votes` INT(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE UNIQUE INDEX `idx_mobile` ON `user` (`mobile`);
