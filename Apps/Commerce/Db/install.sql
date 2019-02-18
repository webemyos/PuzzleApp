CREATE TABLE IF NOT EXISTS `CommerceCommerce` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Title` VARCHAR(200)  NULL ,
`SmallDescription` TEXT  NULL ,
`LongDescription` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_CommerceCommerce` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EeCommerceProductCategory` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CommerceId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommerce_EeCommerceProductCategory` FOREIGN KEY (`CommerceId`) REFERENCES `EeCommerceCommerce`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

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

CREATE TABLE IF NOT EXISTS `EeCommerceSeanceVente` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Libelle` VARCHAR(200)  NULL ,
`CommerceId` INT  NULL ,
`DateStart` DATETIME  NULL ,
`DateEnd` DATETIME  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommerce_EeCommerceSeanceVente` FOREIGN KEY (`CommerceId`) REFERENCES `EeCommerceCommerce`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

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

CREATE TABLE IF NOT EXISTS `EeCommerceSeanceUser` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`SeanceId` INT  NULL ,
`Ip` VARCHAR(200)  NULL ,
`Navigateur` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceSeanceVente_EeCommerceSeanceUser` FOREIGN KEY (`SeanceId`) REFERENCES `EeCommerceSeanceVente`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EeCommerceCommande` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`StateId` INT  NULL ,
`Numero` VARCHAR(200)  NULL ,
`DateCreated` DATETIME  NULL ,
`DateValidation` DATETIME  NULL ,
`DatePrisEnChargePartenaire` DATETIME  NULL ,
`DateExpeditionPartenaire` DATETIME  NULL ,
`DateLivraisonPrevu` DATETIME  NULL ,
`DateLivraisonReel` DATETIME  NULL ,
`AdresseLivraisonId` INT  NULL ,
`AdresseFacturationId` INT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;  

CREATE TABLE IF NOT EXISTS `EeCommerceCommandeLine` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CommandeId` INT  NULL ,
`EntityId` INT  NULL ,
`Price` FLOAT  NULL ,
`Quantite` INT  NULL ,
`StateId` INT  NULL ,
`PricePort` FLOAT  NULL ,
`ReferenceId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommande_EeCommerceCommandeLine` FOREIGN KEY (`CommandeId`) REFERENCES `EeCommerceCommande`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EeCommerceUserFournisseur` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`FournisseurId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommerce_EeCommerceUserFournisseurUser` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`),
CONSTRAINT `EeCommerceCommerce_EeCommerceUserFournisseurFournisseur` FOREIGN KEY (`FournisseurId`) REFERENCES `EeCommerceFournisseur`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EeCommerceProductReference` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`ProductId` INT  NULL ,
`Code` VARCHAR(200)  NULL ,
`Libelle` VARCHAR(200)  NULL ,
`Quantity` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceProduct_EeCommerceProductReference` FOREIGN KEY (`ProductId`) REFERENCES `EeCommerceProduct`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EeCommerceCommandeAdresse` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`TypeId` INT  NULL ,
`CityId` INT  NULL ,
`Name` varchar(30)  NULL ,
`Adress` TEXT  NULL ,
`Complement` TEXT  NULL ,
`CodePostal` varchar(30)  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

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

CREATE TABLE IF NOT EXISTS `EeCommerceBonCommande` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CommandeId` INT  NULL ,
`FournisseurId` INT  NULL ,
`Numero` VARCHAR(200)  NULL ,
`DateCreated` DATETIME  NULL ,
`DateValided` DATETIME  NULL ,
`DateExpedited` DATETIME  NULL ,
`StateId` INT  NULL ,
`File` TEXT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EeCommerceLike` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`ProductId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_EeCommerceLike` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`),
CONSTRAINT `EeCommerceProduct_EeCommerceLike` FOREIGN KEY (`ProductId`) REFERENCES `EeCommerceProduct`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

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

CREATE TABLE IF NOT EXISTS `EeCommerceFicheProduct` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CategoryId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Code` VARCHAR(200)  NULL ,
`KeyWord` TEXT  NULL ,
`ShortDescription` TEXT  NULL ,
`LongDescription` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceProductCategory_EeCommerceFicheProduct` FOREIGN KEY (`CategoryId`) REFERENCES `EeCommerceProductCategory`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EeCommerceFicheProductProduct` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`FicheId` INT  NULL ,
`ProductId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceFicheProduct_EeCommerceFicheProductProduct` FOREIGN KEY (`FicheId`) REFERENCES `EeCommerceFicheProduct`(`Id`),
CONSTRAINT `EeCommerceProduct_EeCommerceFicheProductProduct` FOREIGN KEY (`ProductId`) REFERENCES `EeCommerceProduct`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EeCommerceCoupon` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Code` VARCHAR(200)  NULL ,
`Libelle` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`Type` INT  NULL ,
`Reduction` INT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 