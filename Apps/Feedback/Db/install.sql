CREATE TABLE IF NOT EXISTS `FeedbackFeedback` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Label` TEXT  NULL ,
`Description` TEXT  NULL ,
`DateCreated` DATE  NULL ,
`UserId` INT  NULL ,
`StateId` INT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_FeedbackFeedback` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 