CREATE TABLE IF NOT EXISTS `EeCommerceVirement` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CommandeId` INT  NULL ,
`FournisseurId` FLOAT  NULL ,
`Montant` float  NULL ,
`DateCreated` DATETIME  NULL ,
`StateId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommande_EeCommerceVirement` FOREIGN KEY (`CommandeId`) REFERENCES `EeCommerceCommande`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 