<table class='card' >
       <tr style='padding-top:15px'>
       <th></th>
        <th>{{GetCode(VenteGivree.Product)}}</th>
        <th>{{GetCode(VenteGivree.Price)}}</th>
        <th>{{GetCode(VenteGivree.PricePort)}}</th>
        <th>{{GetCode(VenteGivree.LineTotal)}}</th>
       </tr>

       {{foreach}}
       <tr> 
            <td>{{element->GetImage()}}</td>
            <td>{{element->Vente->Value->Product->Value->NameProduct->Value}}</td>
            <td>{{element->Price->Value}}</td>
            <td>{{element->PricePort->Value}}</td>
            <td>{{element->GetTotal()}}</td>
            <td><i class='fa fa-times' onclick='VenteGivreeAction.RemoveProduct(this, {{element->IdEntite}})'>&nbsp</i></td>
       </tr>

       {{/foreach}}

       <tr>
           <td colspan='4' >{{GetCode(Total)}}</td>
           <td>{{lbTotal}}</td>
       </tr>
</table>