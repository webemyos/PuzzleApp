CREATE TABLE IF NOT EXISTS `CommerceCommerce` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Title` VARCHAR(200)  NULL ,
`SmallDescription` TEXT  NULL ,
`LongDescription` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_CommerceCommerce` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 