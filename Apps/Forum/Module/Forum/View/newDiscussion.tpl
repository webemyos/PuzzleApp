<section>
  
    <h2>{{GetCode(Forum.NewMessageInCategory)}} : {{Category->Name->Value}}</h2>

    {{if Connected == true}}

        {{if Model->State = Init}}
            {{RenderModel()}}
        {{/if Model->State = Init}}

        {{if Model->State = Updated}}

        <div class='success'>
          {{GetCode(Forum.MessageSaved)}}
        </div>

        <a class='btn btn-success' href='{{GetPath(/Forum/Category/{{Category->Code->Value}})}}' >
            {{GetCode(Forum.ReturnToCategory)}}
        </a>

        {{/if Model->State = Updated}}

    {{/if Connected == true}}
    
    {{if Connected == false}}
       {{GetCode(Forum.MustBeConnected)}}
       
       <br/>
       <a class='btn btn-primary' href='{{GetPath(/singup)}}' >
            {{GetCode(Singup)}}
        </a>

    {{/if Connected == false}}

    
</section>