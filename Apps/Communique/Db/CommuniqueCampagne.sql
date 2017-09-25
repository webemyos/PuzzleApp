CREATE TABLE IF NOT EXISTS `CommuniqueCampagne` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CommuniqueId` INT  NULL ,
`DateSended` DATE  NULL ,
`Title` VARCHAR(200)  NULL ,
`Message` TEXT  NULL ,
`NumberEmailSended` INT  NULL ,
`NumberEmailOpen` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `Communique_CommuniqueCamagne` FOREIGN KEY (`CommuniqueId`) REFERENCES `CommuniqueCommunique`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 