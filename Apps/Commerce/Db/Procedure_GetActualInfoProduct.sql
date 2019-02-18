/* 
* Procédure permettant de récuperer les infos produits actuels 
* Mais aussi de mettre a jour les informations
* Ce travail est fait pas la base de donnée afin d'ameliorer les temps de traitement
 */

DROP PROCEDURE IF EXISTS GetActualInfoProduct ;

DELIMITER $$ 
CREATE PROCEDURE GetActualInfoProduct(IN seaId INT, OUT InfoProduct TEXT)

BEGIN 
    -- DECLARATION DES VARIABLES
    DECLARE info TEXT;
    
    -- information sur les ventes
    DECLARE venteId int;
    DECLARE prodId int;
    DECLARE dateStarted datetime;
    DECLARE dateStoped datetime;
    DECLARE pos int;
    DECLARE priceEnCours float;
    DECLARE priceStarted float;
    DECLARE priceMinimum float;
    DECLARE priceDowned float;
    DECLARE timeEnded int;
    DECLARE nbUser int;
    DECLARE seanceEnd datetime;
   

    SET InfoProduct = CONCAT("SeanceId" ,":", seaId ,"|");
    
    -- Information sur la seance
    SELECT DateEnd INTO seanceEnd FROM EeCommerceSeanceVente  WHERE Id = seaId;
  
    -- Nombres d'utilisateurs connectés
    SELECT COUNT(*) INTO nbUser FROM EeCommerceSeanceUser WHERE SeanceId = seaId;
    
    SET InfoProduct = CONCAT(InfoProduct, "User" ,":", nbUser, "|");

    SET pos= 0;

    boucle : LOOP
        SET pos = pos + 1;
        IF pos < 4 THEN
   
           
             -- Recuperation de la vente en cours
            SELECT  Id, ProductId, DateStart, DateEnd, PriceStart, PriceActual, PriceMini, PriceDown, TimeEnd INTO venteId, prodId, dateStarted, dateStoped , priceStarted, priceEnCours, priceMinimum, priceDowned, timeEnded FROM EeCommerceVente WHERE SeanceId = seaId AND Position = pos AND DateEnd is null limit 0,1;

            -- Aucune vente disponible    
            IF venteId IS NULL THEN
                SET InfoProduct = CONCAT(InfoProduct, "VenteId=N","|" );

            ELSE    
                IF dateStarted IS NULL THEN
                    -- Initialisation de la vente
                    SELECT PriceVenteMaxi, PriceVenteMini, PriceDown INTO priceEnCours, priceMinimum, priceDowned FROM EeCommerceProduct WHERE Id = prodId;

                    UPDATE EeCommerceVente SET DateStart = now(), PriceStart = priceEnCours, PriceMini = priceMinimum, PriceActual = priceEnCours, PriceDown=priceDowned,  TimeEnd = 30 WHERE Id = venteId;
                ELSE 
                    -- Mise a jour du prix de la vente
                    IF priceEnCours > (priceMinimum + 1) AND dateStoped IS NULL   THEN

                        UPDATE EeCommerceVente SET PriceActual = Round(PriceActual -  ((priceDowned / 100) * nbUser),2), TimeEnd = TimeEnd - 1 WHERE Id = venteId;
                    ELSE 
					
                        -- Le produit n est pas vendu 
                        IF priceEnCours <= (priceMinimum + 1) OR timeEnded = 0 THEN

                        -- On termine la ligne de vente
                        UPDATE EeCommerceVente SET DateEnd = now() WHERE Id = venteId;

                            -- on recrée une nouvelle ligne Si on et pas proche de la fin de la seance
                            IF now() < seanceEnd THEN    
                                INSERT INTO EeCommerceVente (SeanceId, ProductId, DateStart, DateEnd, PriceStart, PriceMini, PriceDown, Line, Position) values (seaId, prodId, null, null, priceStarted, priceMinimum, priceDowned, 99,  pos);
                            END IF; 

                        END IF ;
                    END IF ;

                END IF ;

                SET InfoProduct = CONCAT(InfoProduct, "VenteId=", venteId, ";ProductId=", prodId, ";DateStart=",dateStarted ,";DateEnd=",IFNULL(dateStoped, "N"), ";PriceActual=", priceEnCours, ";PriceMini=", priceMinimum,";PriceDown=", priceDowned, ";Position=", pos,"; TimeEnd=", timeEnded, "|" );
            END IF;
    
       ITERATE boucle;

        END IF;
            LEAVE boucle;

        END LOOP boucle;   
END $$

DELIMITER ;



set @InfoProduct = "";
CALL GetActualInfoProduct(1, @InfoProduct);
SELECT @InfoProduct;
