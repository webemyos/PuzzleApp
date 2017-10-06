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