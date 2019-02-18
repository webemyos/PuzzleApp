CREATE TABLE IF NOT EXISTS `DevisPrestationCategory` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Libelle` VARCHAR(200)  NULL ,
`Code` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`ProjetId` int  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `DevisProjet_DevisPrestationCategory` FOREIGN KEY (`ProjetId`) REFERENCES `DevisProjet`(`Id`)

) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 