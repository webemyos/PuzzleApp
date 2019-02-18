<h1>{{GetCode(ContactUs)}}</h1>
      
   {{GetForm(/contact)}}
   
        <label>{{GetCode(Email)}}</label>
        {{GetControl(EmailBox, tbEmail,{PlaceHolder=votre Email,Required=true})}}

        <label>{{GetCode(Name)}}</label>
        {{GetControl(TextBox, tbName,{PlaceHolder=votre Nom,Required=true})}}

        <label>{{GetCode(Message)}}</label>
        {{GetControl(TextArea, tbMessage,{PlaceHolder=votre Message,Required=true})}}


        {{if valide == false}}
            {{GetCode(Captcha.Incorrect)}}
        {{/if valide == false}}
        <br/>
        
        {{GetWidget(Captcha)}}

        <br/>
        {{GetControl(Submit,btnSubmit,{Value=Send,CssClass=btn btn-success,)})}}
        
         
        
   {{CloseForm()}}
   
