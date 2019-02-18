<page>
    <style type="text/css">
<!--

table { width:100%; border:1px solid black; font-size:14px; border-collapse:collapse; }
.product {border:solid 2mm #66AACC;}
-->
</style>
    <h1>{{GetCode(BonCommandeNumero)}} : {{BonCommandeNumero}}</h1>
    <table>
        <tr>
            <td colspan='2'>
                <table>
                    <tr>
                        <td>{{GetCode(BonCommandeNumero)}} :</td><td>{{BonCommandeNumero}} </td>
                    </tr>
                    <tr>
                        <td>{{GetCode(BonCommandeDate)}} : </td><td>{{BonCommandeDate}}</td>
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
            </td>
        </tr>
        
        <tr>
            <td>
                <h4>{{fournisseur}}</h4>
                {{adressFournisseur}} 
            </td>
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
                </table>
            </td>
            <td></td>
        </tr>
      </table>
</page>