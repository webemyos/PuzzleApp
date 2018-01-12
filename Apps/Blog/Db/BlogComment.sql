CREATE TABLE IF NOT EXISTS `BlogComment` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`ArticleId` INT  NULL ,
`Message` TEXT  NULL ,
`DateCreated` DATE  NULL ,
`Actif` INT  NULL ,
`UserId` INT  NULL ,
`UserName` VARCHAR(250)  NULL ,
`UserEmail`  VARCHAR(250)   NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `BlogArticle_BlogComment` FOREIGN KEY (`ArticleId`) REFERENCES `BlogArticle`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 