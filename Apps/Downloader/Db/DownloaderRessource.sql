CREATE TABLE IF NOT EXISTS `DownloaderRessource` (
`Id` int(11) NOT NULL AUTO_INCREMENT,
`UserId` INT  NULL ,
`Name` TEXT  NULL ,
`Code` TEXT  NULL ,
`Description` TEXT  NULL ,
`Url` TEXT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;
