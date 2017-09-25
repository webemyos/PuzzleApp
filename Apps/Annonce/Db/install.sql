CREATE TABLE IF NOT EXISTS `AnnonceAnnonce` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Title` TEXT  NULL ,
`Description` TEXT  NULL ,
`DateCreated` DATE  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_AnnonceAnnonce` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `AnnonceReponse` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`AnnonceId` INT  NULL ,
`Reponse` TEXT  NULL ,
`DateCreated` DATE  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_AnnonceReponse` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`),
CONSTRAINT `AnnonceAnnonce_AnnonceReponse` FOREIGN KEY (`AnnonceId`) REFERENCES `AnnonceAnnonce`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 