CREATE TABLE IF NOT EXISTS `TaskGroup` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Title` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`Actif` INT  NULL ,
`DateCreated` DATE  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_TaskGroup` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 