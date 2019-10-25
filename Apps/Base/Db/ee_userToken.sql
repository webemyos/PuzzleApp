CREATE TABLE IF NOT EXISTS `ee_userToken` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Token` TEXT  NULL ,
`expire` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_ee_userToken` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 