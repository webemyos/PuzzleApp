 CREATE TABLE IF NOT EXISTS `DevisProjet` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Libelle` TEXT  NULL ,
`Description` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `DevisProjet_eeuse` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)

) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `DevisPrestationCategory` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Libelle` VARCHAR(200)  NULL ,
`Code` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`ProjetId` int  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `DevisProjet_DevisPrestationCategory` FOREIGN KEY (`ProjetId`) REFERENCES `DevisProjet`(`Id`)

) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `DevisPrestation` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CategoryId` INT  NULL ,
`Libelle` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `DevisPrestationCategory_DevisPrestation` FOREIGN KEY (`CategoryId`) REFERENCES `DevisPrestationCategory`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;

CREATE TABLE IF NOT EXISTS `DevisAsk` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`PrestationId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Email` VARCHAR(200)  NULL ,
`Phone` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`DateCreated` DATE  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

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

CREATE TABLE IF NOT EXISTS `DevisDevisLine` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`DevisId` INT  NULL ,
`Prestation` TEXT  NULL ,
`Quantity` INT  NULL ,
`Price` FLOAT  NULL ,
`Total` FLOAT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `DevisDevis_DevisDevisLine` FOREIGN KEY (`DevisId`) REFERENCES `DevisDevis`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 