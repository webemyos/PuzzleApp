<page>
    <style type="text/css">
<!--

table { width:100%; border:1px solid black; font-size:14px; border-collapse:collapse; }
.product {border:solid 2mm #66AACC;}
-->
</style>
    <h1>{{GetCode(FactureNumero)}} : {{factureNumero}}</h1>
    <table>
        <tr>
            <td colspan='2'>
                <table>
                    <tr>
                        <td>{{GetCode(FactureNumero)}} :</td><td>{{factureNumero}} </td>
                    </tr>
                    <tr>
                        <td>{{GetCode(FactureDate)}} : </td><td>{{factureDate}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><h4>{{GetCode(adresseLivraison)}} </h4>
                {{adressLivraison}} {{complementLivraison}}
                {{codePostalLivraison}} {{cityLivraison}}
                
                <h4>{{GetCode(adresseFacturation)}}</h4>
                {{adressFacturation}} {{complementFacturation}}
                {{codePostalFacturation}} {{cityFacturation}}
            </td>
        </tr>
        
        <tr>
            <td>VenteGivree.com</td>
        </tr>
        
        
        <tr>
            <td></td>
            <td colspan ='2'>
                <table style="width: 100%; border: solid 1px #000000;">
                    <tr>
                        <th style="background-color: #BEBEBE;width:200px">{{GetCode(Product)}}</th>
                        <th style="background-color: #BEBEBE;">{{GetCode(Price)}}</th>
                        <th style="background-color: #BEBEBE;">{{GetCode(PricePort)}}</th>
                        <th style="background-color: #BEBEBE;">{{GetCode(Total)}}</th>
                    </tr>
                    {{foreach}}
                        <tr>
                            <td style="border: solid 1px #AEAEAE;">{{element-NameProduct-}}</td>
                            <td style="border: solid 1px #AEAEAE;">{{element-Price-}}</td>
                            <td style="border: solid 1px #AEAEAE;">{{element-PricePort-}}</td>
                            <td style="border: solid 1px #AEAEAE;">{{element-PriceTotal-}}</td>
                        </tr>
                    {{/foreach}}
                    
                    <tr>
                        <td colspan='2'></td>
                        <td>{{GetCode(TOTAL)}} </td>
                        <td>{{total}}</td>
                    </tr>
                    
                    
                </table>
            </td>
            <td></td>
        </tr>
      </table>
      <table>
        <tr>
            <td colspan='2'></td>
            <td>VenteGivree.com | Sasu . Siret n.98390839973</td>
        </tr>
        <tr>
            <td>compagnino francesco</td>
        </tr>
      </table>
</page>