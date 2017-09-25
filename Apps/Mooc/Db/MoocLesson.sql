CREATE TABLE IF NOT EXISTS `MoocLesson` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`MoocId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`Content` TEXT  NULL ,
`Video` TEXT  NULL ,
`Actif` int(1)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `MoocMooc_MoocLesson` FOREIGN KEY (`MoocId`) REFERENCES `MoocMooc`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 