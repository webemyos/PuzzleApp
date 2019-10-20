CREATE TABLE IF NOT EXISTS `EeCommerceProduct` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CommerceId` INT  NULL ,
`FournisseurId` INT  NULL ,
`CategoryId` INT  NULL ,
`NameProduct` VARCHAR(200)  NULL ,
`SmallDescriptionProduct` TEXT  NULL ,
`LongDescriptionProduct` TEXT  NULL ,
`Actif` INT  NULL ,
`PriceBuy` float  NULL ,
`PriceVenteMini` float  NULL ,
`PriceVenteMaxi` float  NULL ,
`PricePort` float  NULL ,
`PriceDown` float  NULL ,
`Quantity` INT  NULL ,
`ImageDefault` TEXT  NULL ,
`DeliveryDelay` int  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommerce_EeCommerceProduct` FOREIGN KEY (`CommerceId`) REFERENCES `EeCommerceCommerce`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 