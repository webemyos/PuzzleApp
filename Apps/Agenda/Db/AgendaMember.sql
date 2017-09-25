CREATE TABLE IF NOT EXISTS `AgendaMember` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EventId` int(11) ,
  `UserId` int(11) ,
  `Accept` TINYINT(1)  NULL ,
  PRIMARY KEY (`Id`),
  CONSTRAINT `eeAgenda_member_user` FOREIGN KEY (`UserId`) REFERENCES ee_user(`Id`),
  CONSTRAINT `eeAgenda_member_event` FOREIGN KEY (`EventId`) REFERENCES AgendaEvent(`Id`))
  ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;