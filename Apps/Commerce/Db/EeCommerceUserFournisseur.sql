CREATE TABLE IF NOT EXISTS `EeCommerceUserFournisseur` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`FournisseurId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommerce_EeCommerceUserFournisseurUser` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`),
CONSTRAINT `EeCommerceCommerce_EeCommerceUserFournisseurFournisseur` FOREIGN KEY (`FournisseurId`) REFERENCES `EeCommerceFournisseur`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 