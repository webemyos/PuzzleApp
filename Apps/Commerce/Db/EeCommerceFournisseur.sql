CREATE TABLE IF NOT EXISTS `EeCommerceFournisseur` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CommerceId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Contact` TEXT  NULL ,
`Email` VARCHAR(200)  NULL ,
`Telephone` VARCHAR(200)  NULL ,
`Adresse` TEXT  NULL ,
`Commission` VARCHAR(50)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommerce_EeCommerceFournisseur` FOREIGN KEY (`CommerceId`) REFERENCES `EeCommerceCommerce`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 