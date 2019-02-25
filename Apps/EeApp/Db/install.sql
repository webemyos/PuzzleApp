CREATE TABLE IF NOT EXISTS `EeAppCategory` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Name` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EeAppApp` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CategoryId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`Actif` INT NULL,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeAppCategory_EeAppApp` FOREIGN KEY (`CategoryId`) REFERENCES `EeAppCategory`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 


CREATE TABLE IF NOT EXISTS `EeAppUser` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`AppId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_EeAppUser` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`),
CONSTRAINT `EeApp_EeAppUser` FOREIGN KEY (`AppId`) REFERENCES `EeAppApp`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 


CREATE TABLE IF NOT EXISTS `EeAppAdmin` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`AppId` INT  NULL ,
`UserId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeAppApp_EeAppAdmin` FOREIGN KEY (`AppId`) REFERENCES `EeAppApp`(`Id`),
CONSTRAINT `ee_user_EeAppAdmin` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

INSERT INTO EeAppCategory (`Name`) VALUE ('Administration');
INSERT INTO EeAppApp(`CategoryId`, `Name`, `Description`) VALUE( 1, "EeApp", "Gestionnaires des applications");
INSERT INTO EeAppAdmin(`UserId`, `AppId`) VALUE( 1, 1);

INSERT INTO EeAppApp(`CategoryId`, `Name`, `Description`) VALUE( 1, "Ide", "Application de développement");
INSERT INTO EeAppApp(`CategoryId`, `Name`, `Description`) VALUE( 1, "Lang", "Gestionnaire des traductions");


