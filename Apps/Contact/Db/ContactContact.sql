CREATE TABLE IF NOT EXISTS `ContactContact` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`ContactId` INT  NULL ,
`StateId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`FirstName` VARCHAR(200)  NULL ,
`Email` VARCHAR(200)  NULL ,
`Phone` VARCHAR(200)  NULL ,
`Mobile` VARCHAR(200)  NULL ,
`Adresse` VARCHAR(200)  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_ContactContact` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`),
CONSTRAINT `ee_contact_ContactContact` FOREIGN KEY (`ContactId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 