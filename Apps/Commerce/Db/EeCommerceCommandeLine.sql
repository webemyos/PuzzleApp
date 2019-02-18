CREATE TABLE IF NOT EXISTS `EeCommerceCommandeLine` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CommandeId` INT  NULL ,
`EntityId` INT  NULL ,
`Price` DECIMAL(10,2)  NULL ,
`Quantite` INT  NULL ,
`StateId` INT  NULL ,
`PricePort` DECIMAL(10,2)  NULL ,
`ReferenceId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommande_EeCommerceCommandeLine` FOREIGN KEY (`CommandeId`) REFERENCES `EeCommerceCommande`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 