<h1>{{GetCode(ContactUs)}}</h1>
      
   {{GetForm(/contact)}}
   
        <label>{{GetCode(Email)}}</label>
        {{GetControl(EmailBox, tbEmail,{PlaceHolder=votre Email,Required=true})}}

        <label>{{GetCode(Name)}}</label>
        {{GetControl(TextBox, tbNamel,{PlaceHolder=votre Nom,Required=true})}}

        <label>{{GetCode(Message)}}</label>
        {{GetControl(TextArea, tbNamel,{PlaceHolder=votre Message,Required=true})}}

        
        <br/>
        {{GetControl(Submit,btnSubmit,{Value=Send,CssClass=btn btn-success,)})}}
        
         
        
   {{CloseForm()}}
   
