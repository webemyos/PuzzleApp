CREATE TABLE IF NOT EXISTS `ComunityMessage` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`ComunityId` INT  NULL ,
`UserId` INT  NULL ,
`Type` INT  NULL ,
`Title` VARCHAR(200)  NULL ,
`Message` TEXT  NULL ,
`DateCreated` DATE  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ComunityComunity_ComunityMessage` FOREIGN KEY (`ComunityId`) REFERENCES `ComunityComunity`(`Id`),
CONSTRAINT `ee_user_ComunityMessage` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 