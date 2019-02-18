CREATE TABLE IF NOT EXISTS `DevisPrestation` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CategoryId` INT  NULL ,
`Libelle` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `DevisPrestationCategory_DevisPrestation` FOREIGN KEY (`CategoryId`) REFERENCES `DevisPrestationCategory`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;