CREATE TABLE IF NOT EXISTS `EeCommerceFacture` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CommandeId` INT  NULL ,
`PriceTotal` FLOAT  NULL ,
`PriceTva` VARCHAR(200)  NULL ,
`Numero` VARCHAR(200)  NULL ,
`DateCreated` DATETIME  NULL ,
`StateId` INT  NULL ,
`File` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommande_EeCommerceFacture` FOREIGN KEY (`CommandeId`) REFERENCES `EeCommerceCommande`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 