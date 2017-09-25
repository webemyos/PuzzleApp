<h1>{{Article->Name->Value}}</h1>

  {{Article->Content->Value}}

<h3>{{GetCode(Comment)}}</h3>


<div>
    <div id='dvAddComment' >
       {{GetCode(YourName)}}
       {{GetControl(TextBox,tbName)}}
       {{GetCode(YourEmail)}}
       {{GetControl(EmailBox,tbEmail)}}
       {{GetCode(YourMessage)}}
       {{GetControl(TextArea,tbComment)}}

       {{GetControl(Submit,btnSubmit,{Value=Send,CssClass=btn btn-success,OnClick=BlogAction.AddComment('{{Article->Code->Value}}')})}}

    </div>
</div>

       <h3>{{GetCode(Comments)}}</h3>
{{foreach Comments}}
    <div class='col-md-12' style='border-top:1px solid grey; width:100%'>
        <h4>{{element->UserName->Value}}</h4>
        <p>{{element->Message->Value}}</p>
    </div>    
{{/foreach Comments}}
       
       
<h3>{{GetCode(EeBlog.YouCanLike)}}</h3>

{{foreach Articles}}
   <div class='col-md-4'>
      <div class='col-md-12' >
           {{element->GetImage()}}
      </div>
      <div class='col-md-12'>
           <h4>{{element->Name->Value}}</h4>
           {{element->GetSmallDescription()}}
      </div>
      <div  class='col-md-12'>
           <a href='{{GetPath(/Blog/Article/)}}{{element->GetUrlCode()}}' >{{GetCode(ReadArticle)}} </a>
      </div>
   </div>
{{/foreach Articles}}
