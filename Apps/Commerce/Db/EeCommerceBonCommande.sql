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