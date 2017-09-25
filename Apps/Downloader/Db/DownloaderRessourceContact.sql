CREATE TABLE IF NOT EXISTS `DownloaderRessourceContact` (
`Id` int(11) NOT NULL AUTO_INCREMENT,
`RessourceId` INT  NULL ,
`Email` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeDownloaderRessource_EeDownloaderRessourceContact` FOREIGN KEY (`RessourceId`) REFERENCES `DownloaderRessource`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;
