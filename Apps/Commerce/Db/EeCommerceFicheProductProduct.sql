CREATE TABLE IF NOT EXISTS `EeCommerceFicheProductProduct` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`FicheId` INT  NULL ,
`ProductId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceFicheProduct_EeCommerceFicheProductProduct` FOREIGN KEY (`FicheId`) REFERENCES `EeCommerceFicheProduct`(`Id`),
CONSTRAINT `EeCommerceProduct_EeCommerceFicheProductProduct` FOREIGN KEY (`ProductId`) REFERENCES `EeCommerceProduct`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 