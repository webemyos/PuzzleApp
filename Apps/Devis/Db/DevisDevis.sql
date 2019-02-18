CREATE TABLE IF NOT EXISTS `DevisDevis` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`ProjetId` INT  NULL ,
`IsModele` INT  NULL ,
`InformationSociete` TEXT  NULL ,
`InformationClient` TEXT  NULL ,
`Number` VARCHAR(200)  NULL ,
`DateCreated` DATE  NULL ,
`DatePaiment` DATE  NULL ,
`TypePaiment` VARCHAR(200)  NULL ,
`InformationComplementaire` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `DevisProjet_DevisDevis` FOREIGN KEY (`ProjetId`) REFERENCES `DevisProjet`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 