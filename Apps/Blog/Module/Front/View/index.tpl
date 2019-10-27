<h1>{{GetCode(Blog.LastArticle)}}</h1>
     {{foreach Article}}
        <div>
           <h2>{{element->Name->Value}}</h2>

           <div class='col-md-2' >
                {{element->GetImage()}}
           </div>
           <div class='col-md-6'>
                {{element->Description->Value}}
           </div>
           <div class='col-md-12'>
            <a href='{{GetPath(/Blog/Article/)}}{{element->GetUrlCode()}}'>{{GetCode(ReadArticle)}}</a>
          </div>
           <div class="clearfix"></div>
        </div>
        {{/foreach Article}}

</h1>
