CREATE TABLE IF NOT EXISTS `ForumCategory` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`ForumId` INT  NULL ,
`Name` VARCHAR(200) NULL ,
`Description` TEXT NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ForumForum_ForumCategory` FOREIGN KEY (`ForumId`) REFERENCES `ForumForum`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 