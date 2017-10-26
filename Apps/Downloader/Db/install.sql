CREATE TABLE IF NOT EXISTS `DownloaderRessource` (
`Id` int(11) NOT NULL AUTO_INCREMENT,
`UserId` INT  NULL ,
`Name` TEXT  NULL ,
`Code` TEXT  NULL ,
`Url` TEXT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;

CREATE TABLE IF NOT EXISTS `DownloaderRessourceContact` (
`Id` int(11) NOT NULL AUTO_INCREMENT,
`RessourceId` INT  NULL ,
`UserId` INT  NULL ,
`Email` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeDownloaderRessource_EeDownloaderRessourceContact` FOREIGN KEY (`RessourceId`) REFERENCES `DownloaderRessource`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;
