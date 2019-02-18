CREATE TABLE IF NOT EXISTS `ForumForum` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Name` VARCHAR(200) NULL ,
`Description` TEXT NULL ,
`UserId` INT  NULL ,
`Default` INT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_ForumForum` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `ForumCategory` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`ForumId` INT  NULL ,
`Name` VARCHAR(200) NULL ,
`Code` VARCHAR(200) NULL ,
`Description` TEXT NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ForumForum_ForumCategory` FOREIGN KEY (`ForumId`) REFERENCES `ForumForum`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

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