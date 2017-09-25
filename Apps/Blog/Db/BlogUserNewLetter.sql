CREATE TABLE IF NOT EXISTS `BlogUserNewLetter` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`BlogId` INT  NULL ,
`Email` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `BlogBlog_BlogUserNewLetter` FOREIGN KEY (`BlogId`) REFERENCES `BlogBlog`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 