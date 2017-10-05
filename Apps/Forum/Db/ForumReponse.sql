CREATE TABLE IF NOT EXISTS `ForumReponse` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`MessageId` INT  NULL ,
`Message` TEXT  NULL ,
`UserId` INT  NULL ,
`DateCreated` DATE  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ForumMessage_ForumReponse` FOREIGN KEY (`MessageId`) REFERENCES `ForumMessage`(`Id`),
CONSTRAINT `ee_user_ForumReponse` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 