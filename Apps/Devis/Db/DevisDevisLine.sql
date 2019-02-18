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