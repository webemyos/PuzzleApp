CREATE TABLE IF NOT EXISTS `EeCommerceSeanceVente` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Libelle` VARCHAR(200)  NULL ,
`CommerceId` INT  NULL ,
`DateStart` DATETIME  NULL ,
`DateEnd` DATETIME  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommerce_EeCommerceSeanceVente` FOREIGN KEY (`CommerceId`) REFERENCES `EeCommerceCommerce`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 