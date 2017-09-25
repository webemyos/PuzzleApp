CREATE TABLE IF NOT EXISTS `CommuniqueListMember` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`ListId` INT  NULL ,
`FirstName` Varchar(200)  NULL ,
`Name` Varchar(200)  NULL ,
`Email` Varchar(200)  NULL ,
`Sexe` INT  NULL ,
`Actif` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `CommuniqueListContact_CommuniqueListMember` FOREIGN KEY (`ListId`) REFERENCES `CommuniqueListContact`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 