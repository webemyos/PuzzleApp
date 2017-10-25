<div class='row'>

    {{if Form->Actif->Value == 0}}
            {{GetCode(Form.NoActif)}}
    {{/if Form->Actif->Value == 0}} 


    {{if Form->Actif->Value == 1}}
        <h1>{{GetCode(Form.CompleteForm)}}</h1>

       <div class='col-md-12' >
            <h2>{{Form->Libelle->Value}}</h2>
            <p>{{Form->Commentaire->Value}}</p>

            {{GetForm(/Form/detail/{{Form->Code->Value}})}}
            
            
            <ul>
            {{foreach Questions}}
              <li>
                  
                   {{element->Libelle->Value}}
                  
                   <p>
                   {{if element->Type->Value == 0}}
                    {{GetControl(TextBox)}}
                   {{/if element->Type->Value == 0}}
                   
                   {{if element->Type->Value == 1}}
                    {{GetControl(TextArea)}}
                   {{/if element->Type->Value == 1}}
                   
                   {{if element->Type->Value == 2}}
                    Merci de selectionner un elements ci dessous
                    
                        {{GetControl(ListRadio, lstResponse,{Name=reponse,Elements={{element->GetReponse()}}})}}
                        
                   {{/if element->Type->Value == 2}}
                   
                   {{if element->Type->Value == 3}}
                   
                   Vous pouvez selectionner une ou plusieurs options
                        {{GetControl(ListCheckBox, lstResponse,{Elements={{element->GetReponse()}}})}}
                    {{/if element->Type->Value == 3}}
                   
                   {{if element->Type->Value == 4}}
                   Selectionner un élements dans la liste ci-dessous
                    {{GetControl(ListBox, lstResponse,{Options={{element->GetReponse()}}})}}
                   {{/if element->Type->Value == 4}}
                   </p>
                   
               </li>
             {{/foreach Questions}}
            </ul>
            </div>
            <div style='text-align:right'>
                {{GetControl(Submit,btnSend,{Value=Send,CssClass=btn btn-success})}}    
            </div>
            
           {{CloseForm()}}
            
    {{/if Form->Actif->Value == 1}}
        
</div>
       
