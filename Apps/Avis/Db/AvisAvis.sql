CREATE TABLE IF NOT EXISTS `AvisAvis` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Name` VARCHAR(200)  NULL ,
`Email` VARCHAR(200)  NULL ,
`Avis` TEXT  NULL ,
`DateCreated` DATE  NULL ,
`Actif` INT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 