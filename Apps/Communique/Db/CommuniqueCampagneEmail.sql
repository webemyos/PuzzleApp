CREATE TABLE IF NOT EXISTS `CommuniqueCampagneEmail` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CampagneId` INT  NULL ,
`Email` VARCHAR(200)  NULL ,
`DateOpen` DATE  NULL ,
`NumberOpen` INT  NULL ,
PRIMARY KEY (`Id`)) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 