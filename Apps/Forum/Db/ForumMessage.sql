CREATE TABLE IF NOT EXISTS `ForumMessage` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CategoryId` INT  NULL ,
`UserId` INT  NULL ,
`Title` VARCHAR(200)  NULL ,
`Code` VARCHAR(200)  NULL ,
`Message` TEXT  NULL ,
`DateCreated` DATE  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ForumForum_ForumMessage` FOREIGN KEY (`CategoryId`) REFERENCES `ForumCategory`(`Id`),
CONSTRAINT `ee_user_ForumMessage` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 