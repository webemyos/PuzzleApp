<h1>{{Article->Name->Value}}</h1>

  {{Article->Content->Value}}

<div>
    <div id='dvAddComment' >
         {{AddComment}}
    </div>
</div>

<h3>{{GetCode(Blog.Comments)}}</h3>
 {{foreach Comments}}
     <div class='col-md-12' style='border-top:1px solid grey; width:100%'>
         <h4>{{element->UserName->Value}}</h4>
         <p>{{element->Message->Value}}</p>
     </div>    
 {{/foreach Comments}}
       
       
<h3>{{GetCode(Blog.YouCanLike)}}</h3>

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
