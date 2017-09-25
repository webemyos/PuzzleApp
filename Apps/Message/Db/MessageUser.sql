CREATE TABLE IF NOT EXISTS `MessageUser` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`MessageId` INT  NULL ,
`UserId` INT  NULL ,
`Read` INT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `MessageMessage_MessageUser` FOREIGN KEY (`MessageId`) REFERENCES `MessageMessage`(`Id`),
CONSTRAINT `ee_user_MessageUser` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 