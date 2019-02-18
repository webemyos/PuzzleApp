<div id='dvDevis'>
<table>
    <tr>
        <th colspan='3'>
            <h2>Devis Numero : {{Number}}</h2> 
        </th>
    </tr>
    
    <tr>
        <td>
            <h3>Société</h3>
            {{InformationSociete}}
        </td>
        <td></td>
        <td>   <h3>Coordonées client</h3>
      {{InformationClient}}
    </td>
    </tr>
    <tr>
        <td>Date du devis : {{DateCreated}}</td>
        <td>Date paiement: {{DatePaiment}}</td>
        <td>Type de reglement: {{TypePaiment}}</td>
    </tr>
    <tr style='border:1px solid grey'>
        <td colspan='3'>
            <input type='text' placeholder='Prestation' id='tbPrestation' />
            <input type='text' placeholder='Nombre' id='tbNbr'  />
            <input type='text' placeholder='Prix' id='tbPrice' />
            <i class='fa fa-plus' value='addLigne' onclick='DevisAction.AddLine(this, {{devisId}})'/>
        </td>
    </tr>
    <tr>
        <td colspan='3'>
            <table id='tabLine' style='border:1px solid grey'>
            {{foreach}}
                <tr>
                    <td><input type='text'  value='{{element->Prestation->Value}}' /></td>
                    <td><input type='text'  class='number' value='{{element->Quantity->Value}}' /></td>
                    <td><input type='text' class='price' value='{{element->Price->Value}}' /></td>
                    <td><input type='text' disabled='disabled' class='subTotal'  value='{{element->Total->Value}}' /></td>
                </tr>
            {{/foreach}}
           </table>
         </td>
    </tr>
    <tr>
        <td></td>
        <td>
            Total : <input type='text' id='tbTotal' />
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td><h3>Informations complémentaires</h3>
        {{InformationComplementaire}}
        </td>
    </tr>  
    <tr>
        <td colspan='3' style='text-align:right'>{{btnSave}} {{btnImprime}}</td>
    </tr>
</table>
</div>