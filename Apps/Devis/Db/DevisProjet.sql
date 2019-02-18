 CREATE TABLE IF NOT EXISTS `DevisProjet` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Libelle` TEXT  NULL ,
`Description` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `DevisProjet_eeuse` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)

) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 
