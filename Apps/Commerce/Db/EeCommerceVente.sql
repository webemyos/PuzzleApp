CREATE TABLE IF NOT EXISTS `EeCommerceVente` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT,
`SeanceId` INT  NULL ,
`ProductId` INT  NULL ,
`DateStart` DATETIME  NULL ,
`DateEnd` DATETIME  NULL ,
`TimeEnd` int  NULL ,
`PriceStart` FLOAT  NULL ,
`PriceActual` FLOAT  NULL ,
`PriceMini` FLOAT  NULL ,
`PriceDown` FLOAT  NULL ,
`Line` INT  NULL ,
`Position` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceVente_EeCommerceSeanceVente` FOREIGN KEY (`SeanceId`) REFERENCES `EeCommerceSeanceVente`(`Id`),
CONSTRAINT `EeCommerceProduct_EeCommerceVente` FOREIGN KEY (`ProductId`) REFERENCES `EeCommerceProduct`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 