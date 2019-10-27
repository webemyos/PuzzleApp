 <section>
    <div class='col-md-8'>
         {{content}}
    </div>

    <div class='col-md-4'>
          <h2>{{GetCode(Blog.TheBlog)}}</h2>
          {{Blog->Name->Value}}

          {{Blog->Description->Value}}


          <h2>{{GetCode(Blog.Categorys)}}</h2>

          <ul>
          {{foreach Category}}
              <li>
              <a href='{{GetPath(/Blog/Category/)}}{{element->GetUrlCode()}}'>
                  {{element->Name->Value}}
              </a>
              </li>
          {{/foreach Category}}
          </ul>

          <h2>{{GetCode(Blog.LastArticle)}}</h2>
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
              {{inscriptionNewletters}}
          </div>
      </div>
  <div class="clearfix"></div>
</section>
