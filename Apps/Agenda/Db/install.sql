CREATE TABLE IF NOT EXISTS `AgendaEvent` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) ,
  `Title` varchar(500) NOT NULL,
  `DateStart` DATETIME NULL ,
  `DateEnd` DATETIME NULL ,
  `Commentaire` varchar(500) NOT NULL,
  `AppName` VARCHAR(200)  NULL ,
  `AppId` INT  NULL ,
  `EntityName` VARCHAR(200)  NULL ,
  `EntityId` INT  NULL ,
  PRIMARY KEY (`Id`),
  CONSTRAINT `eeAgenda_event` FOREIGN KEY (`UserId`) REFERENCES ee_user(`Id`))
  ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;

CREATE TABLE IF NOT EXISTS `AgendaMember` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EventId` int(11) ,
  `UserId` int(11) ,
  `Accept` TINYINT(1)  NULL ,
  PRIMARY KEY (`Id`),
  CONSTRAINT `eeAgenda_member_user` FOREIGN KEY (`UserId`) REFERENCES ee_user(`Id`),
  CONSTRAINT `eeAgenda_member_event` FOREIGN KEY (`EventId`) REFERENCES AgendaEvent(`Id`))
  ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;
