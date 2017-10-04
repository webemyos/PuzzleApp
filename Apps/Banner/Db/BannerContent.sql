CREATE TABLE IF NOT EXISTS `BannerContent` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`BannerId` INT  NULL ,
`Content` TEXT  NULL ,
`Name` VARCHAR(50)  NULL ,
`Actif` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `BannerBanner_BannerContent` FOREIGN KEY (`BannerId`) REFERENCES `BannerBanner`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 


