

{{Category->Description->Value}}

{{foreach Article}}
   <div>
      <h2>{{element->Name->Value}}</h2>

      <div class='col-md-2' > 
           {{element->GetImage()}}
      </div>
      <div class='col-md-10'>
           {{element->GetSmallDescription()}}
      </div>
      <div class="clearfix"></div>
      <div class='col-md-2' > </div>
      <div class='col-md-10' > 
          {{element->DateCreated->Value}} 
      <a href='{{GetPath(/Blog/Article/)}}{{element->GetUrlCode()}}' >{{GetCode(ReadArticle)}} </a>
      </div>
   </div>
{{/foreach Article}}