CREATE TABLE IF NOT EXISTS `EeCommerceSeanceUser` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`SeanceId` INT  NULL ,
`Ip` VARCHAR(200)  NULL ,
`Navigateur` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceSeanceVente_EeCommerceSeanceUser` FOREIGN KEY (`SeanceId`) REFERENCES `EeCommerceSeanceVente`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 