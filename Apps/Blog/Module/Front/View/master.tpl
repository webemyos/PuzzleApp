 <section>
    <div class='col-md-8'>
         {{content}}
    </div>

    <div class='col-md-4'>
          <h2>{{GetCode(TheBlog)}}</h2>
          {{Blog->Name->Value}}

          {{Blog->Description->Value}}


          <h2>{{GetCode(Categorys)}}</h2>

          <ul>
          {{foreach Category}}
              <li>
              <a href='{{GetPath(/Blog/Category/)}}{{element->GetUrlCode()}}'>
                  {{element->Name->Value}}
              </a>
              </li>
          {{/foreach Category}}
          </ul>

          <h2>{{GetCode(LastArticle)}}</h2>
          <ul>
           {{foreach Article}}
              <li>
              <a href='{{GetPath(/Blog/Article/)}}{{element->GetUrlCode()}}'>
                  {{element->Name->Value}}
              </a>
              </li>
          {{/foreach Article}}
          </ul>
          
          <div id='dvNewsLetter' >
              <h2>{{GetCode(Newsletter)}}</h2>
              <p>{{GetCode(Blog.TxtInscriptionNewsLetter)}}</p>
              {{GetForm(/Blog/Subscribe)}}
                {{GetControl(EmailBox,Email,{Required=true,PlaceHolder=Email})}}
            
                {{GetControl(Submit,Send,{Value=Inscription,CssClass=btn btn-primary})}}
            {{CloseForm()}}
          </div>
      </div>
  <div class="clearfix"></div>
</section>
