CREATE TABLE IF NOT EXISTS `CommuniqueCommunique` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Title` TEXT  NULL ,
`Text` TEXT  NULL ,
`Code` TEXT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 


CREATE TABLE IF NOT EXISTS `CommuniqueListContact` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `User_CommuniqueListContact` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `CommuniqueListMember` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`ListId` INT  NULL ,
`FirstName` Varchar(200)  NULL ,
`Name` Varchar(200)  NULL ,
`Email` Varchar(200)  NULL ,
`Sexe` INT  NULL ,
`Actif` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `CommuniqueListContact_CommuniqueListMember` FOREIGN KEY (`ListId`) REFERENCES `CommuniqueListContact`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;

CREATE TABLE IF NOT EXISTS `CommuniqueCampagne` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CommuniqueId` INT  NULL ,
`DateSended` DATE  NULL ,
`Title` VARCHAR(200)  NULL ,
`Message` TEXT  NULL ,
`NumberEmailSended` INT  NULL ,
`NumberEmailOpen` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `Communique_CommuniqueCamagne` FOREIGN KEY (`CommuniqueId`) REFERENCES `CommuniqueCommunique`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;

CREATE TABLE IF NOT EXISTS `CommuniqueCampagneEmail` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CampagneId` INT  NULL ,
`Email` VARCHAR(200)  NULL ,
`DateOpen` DATE  NULL ,
`NumberOpen` INT  NULL ,
PRIMARY KEY (`Id`)) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;   