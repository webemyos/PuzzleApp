<table class='grid'>
    <tr>
        <td>{{GetCode(Reference)}}</td>
         <td>{{GetCode(Libelle)}}</td>
          <td>{{GetCode(Quantite)}}</td>
          <td></td>
    </tr>
    
    {{foreach}}
        <tr>    
            <td>{{element->Code->Value}}</td>
            <td>{{element->Libelle->Value}}</td>
            <td>{{element->Quantity->Value}}</td>
            <td>
                <i class='icon-edit' onclick='EeCommerceAction.EditReference(this, {{element->ProductId->Value}} , {{element->IdEntite}})'>
                <i class='icon-remove' onclick='EeCommerceAction.DeleteReference(this, {{element->ProductId->Value}}, {{element->IdEntite}})'>
            </td>
            
        </tr>
    {{/foreach}}
    
</table>

