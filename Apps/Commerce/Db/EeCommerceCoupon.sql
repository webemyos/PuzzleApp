CREATE TABLE IF NOT EXISTS `EeCommerceCoupon` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Code` VARCHAR(200)  NULL ,
`Libelle` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`Type` INT  NULL ,
`Reduction` INT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 