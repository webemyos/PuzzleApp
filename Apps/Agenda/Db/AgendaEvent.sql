CREATE TABLE IF NOT EXISTS `AgendaEvent` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) ,
  `Title` varchar(500) NOT NULL,
  `Code` varchar(500) NOT NULL,
  `DateStart` DATETIME NULL ,
  `DateEnd` DATETIME NULL ,
  `Commentaire` varchar(500) NOT NULL,
  `Public` TINYINT(1)  NULL ,
  `AppName` VARCHAR(200)  NULL ,
  `AppId` INT  NULL ,
  `EntityName` VARCHAR(200)  NULL ,
  `EntityId` INT  NULL ,
  PRIMARY KEY (`Id`),
  CONSTRAINT `Agenda_event` FOREIGN KEY (`UserId`) REFERENCES ee_user(`Id`))
  ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;