/*
* Procédure pour récupere les 3 produit en cours de vente
* Et les 3 prochain produits
*
*/

DROP PROCEDURE IF EXISTS GetActualProduct ;

DELIMITER $$ 
CREATE PROCEDURE GetActualProduct(IN seaId INT, OUT VenteId1 int, OUT TimeEnd1 int,  OUT VenteId2 int, OUT TimeEnd2 int, OUT VenteId3 int, OUT TimeEnd3 int, OUT NextVenteId1 int , OUT NextVenteId2 int, OUT NextVenteId3 int)

BEGIN 

	 SELECT Id, TimeEnd INTO VenteId1, TimeEnd1 FROM EeCommerceVente WHERE SeanceId = seaId AND DateStart is not null And DateEnd is null and Position = 1 ;
	
	 IF VenteId1 IS NULL THEN

            SELECT Id, TimeEnd INTO VenteId1, TimeEnd1 FROM EeCommerceVente WHERE SeanceId = seaId AND DateStart is null And DateEnd is null and Position = 1 limit 0,1 ;
	 END IF ;

            SELECT Id, TimeEnd INTO VenteId2, TimeEnd2 FROM EeCommerceVente WHERE SeanceId = seaId AND DateStart is not null And DateEnd is null and Position = 2 ;
	
	 IF VenteId2 IS NULL THEN
		
	    SELECT Id, TimeEnd INTO VenteId2, TimeEnd2 FROM EeCommerceVente WHERE SeanceId = seaId AND DateStart is null And DateEnd is null and Position = 2 limit 0,1 ;
		
	 END IF ;

            SELECT Id, TimeEnd INTO VenteId3, TimeEnd3 FROM EeCommerceVente WHERE SeanceId = seaId AND DateStart is not null And DateEnd is null and Position = 3 ;
	
	 IF VenteId3 IS NULL THEN
		
	   SELECT Id, TimeEnd INTO VenteId3, TimeEnd3 FROM EeCommerceVente WHERE SeanceId = seaId AND DateStart is null And DateEnd is null and Position = 3 limit 0,1 ;
	
	 END IF ;
	 
 
	SET NextVenteId1 = (SELECT Id FROM EeCommerceVente Where SeanceId = seaId AND DateStart is null AND Id <> VenteId1 AND Position = 1 Limit 0,1) ;
	SET NextVenteId2 = (SELECT Id FROM EeCommerceVente Where SeanceId = seaId AND DateStart is null AND Id <> VenteId2 AND Position = 2 Limit 0,1) ;
	SET NextVenteId3 = (SELECT Id FROM EeCommerceVente Where SeanceId = seaId AND DateStart is null AND Id <> VenteId3 AND Position = 3 Limit 0,1) ;

END $$

DELIMITER ;

set @Vente1 = "";
set @TimeEnd1 ="";
set @Vente2 = "";
set @TimeEnd2 ="";
set @Vente3 = "";
set @TimeEnd3 ="";
set @NextVente2 = "";
set @NextVente3 = "";
set @NextVente1 = "";


CALL GetActualProduct(1, @Vente1, @TimeEnd1, @Vente2, @TimeEnd2,@Vente3,@TimeEnd3, @NextVente1,@NextVente2,@NextVente3);
SELECT @Vente1,@TimeEnd1,@Vente2,@TimeEnd2,@Vente3,@TimeEnd3, @NextVente1,@NextVente2,@NextVente3;

