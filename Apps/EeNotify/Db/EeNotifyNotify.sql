CREATE TABLE IF NOT EXISTS `EeNotifyNotify` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Code` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`DateCreate` DATE  NULL ,
`DestinataireId` INT  NULL ,
`View` INT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_eeNotify_notify` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 