CREATE TABLE IF NOT EXISTS `MoocMoocUser` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`MoocId` INT  NULL ,
`UserId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `MoocMooc_MoocMoocUser` FOREIGN KEY (`MoocId`) REFERENCES `MoocMooc`(`Id`),
CONSTRAINT `ee_user_MoocMoocUser` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 