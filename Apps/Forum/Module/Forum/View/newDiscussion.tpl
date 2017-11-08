<section>
  
    
    {{if Modele->State == Init}}
        {{RenderModele(Modele)}}
    {{/if Modele->State == Init}}
    
    {{if Modele->State == Updated}}
        {{GetCode(Forum.DiscussionAdded)}}
    {{/if Modele->State == Updated}}
    
        
    
    {{if Modele->Saved == false}}
    
    {{/if Modele->Saved}}
    
    
    
  {{GetForm(\Forum\NewDiscussion)}}
  
  {{GetCode(Forum.Sujet)}}
  {{GetControl(TextBox,sujet,{Required=true})}} 
  
  {{GetCode(Forum.Message)}}
  {{GetControl(TextArea,message,{Required=true})}} 
  
  {{GetControl(Submit,Submit,{Value,Send})}}
    
  {{CloseForm()}}
  
  
  
</section>