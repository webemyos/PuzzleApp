CREATE TABLE IF NOT EXISTS `ComunityComunity` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Name` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;

 CREATE TABLE IF NOT EXISTS `ComunityUser` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`ComunityId` INT  NULL ,
`UserId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_ComunityUser` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`),
CONSTRAINT `ComunityComunity_ComunityUser` FOREIGN KEY (`ComunityId`) REFERENCES `ComunityComunity`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `ComunityMessage` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`ComunityId` INT  NULL ,
`UserId` INT  NULL ,
`Type` INT  NULL ,
`Title` VARCHAR(200)  NULL ,
`Message` TEXT  NULL ,
`DateCreated` DATE  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ComunityComunity_ComunityMessage` FOREIGN KEY (`ComunityId`) REFERENCES `ComunityComunity`(`Id`),
CONSTRAINT `ee_user_ComunityMessage` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `ComunityComment` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`MessageId` INT  NULL ,
`UserId` INT  NULL ,
`TypeId` INT  NULL ,
`Actif` INT  NULL ,
`Message` TEXT  NULL ,
`UserName` TEXT  NULL ,
`Email` TEXT  NULL ,
`DateCreated` DATE  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

