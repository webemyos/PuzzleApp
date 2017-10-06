CREATE TABLE IF NOT EXISTS `ComunityUser` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`ComunityId` INT  NULL ,
`UserId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_ComunityUser` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`),
CONSTRAINT `ComunityComunity_ComunityUser` FOREIGN KEY (`ComunityId`) REFERENCES `ComunityComunity`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 