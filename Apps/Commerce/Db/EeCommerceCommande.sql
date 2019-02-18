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