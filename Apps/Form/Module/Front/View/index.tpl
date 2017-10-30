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
                     {{GetControl(TextBox,tb_{{element->IdEntite}})}}
                    {{/if element->Type->Value == 0}}

                    {{if element->Type->Value == 1}}
                     {{GetControl(TextArea,ta_{{element->IdEntite}})}}
                    {{/if element->Type->Value == 1}}

                    {{if element->Type->Value == 2}}
                         {{GetControl(ListRadio, ls_{{element->IdEntite}},{Name=rb_{{element->IdEntite}},Elements={{element->GetReponse()}}})}}
                    {{/if element->Type->Value == 2}}

                    {{if element->Type->Value == 3}}
                         {{GetControl(ListCheckBox, lcb_{{element->IdEntite}},{Elements={{element->GetReponse()}}})}}
                     {{/if element->Type->Value == 3}}

                    {{if element->Type->Value == 4}}
                     {{GetControl(ListBox, lst_{{element->IdEntite}},{Options={{element->GetReponse()}}})}}
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
       
