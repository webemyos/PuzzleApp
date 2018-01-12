CREATE TABLE IF NOT EXISTS `BlogBlog` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`Style` INT  NULL ,
`Actif` INT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_EeBloBlog` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 


CREATE TABLE IF NOT EXISTS `BlogArticle` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`BlogId` INT  NULL ,
`UserId` INT  NULL ,
`CategoryId` INT  NULL ,
`Actif` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Code` VARCHAR(200)  NULL ,
`KeyWork` TEXT  NULL ,
`Description` TEXT  NULL ,
`Content` TEXT  NULL ,
`DateCreated` DATE  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `BlogBlog_BlogArticle` FOREIGN KEY (`BlogId`) REFERENCES `BlogBlog`(`Id`),
CONSTRAINT `ee_user_BlogArticle` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `BlogUserNewLetter` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`BlogId` INT  NULL ,
`Email` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `BlogBlog_BlogUserNewLetter` FOREIGN KEY (`BlogId`) REFERENCES `BlogBlog`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `BlogCategory` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`BlogId` INT  NULL ,
`Name` VARCHAR(50)  NULL ,
`Code` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `BlogBlog_BlogCategory` FOREIGN KEY (`BlogId`) REFERENCES `BlogBlog`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

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