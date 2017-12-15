<section>
      <h2>{{GetCode(Blog.Subscribe)}}</h2>

        {{if Model->State = Init}}
            {{RenderModel()}}
        {{/if Model->State = Init}}

        {{if Model->State = Updated}}

        <div class='success'>
          {{GetCode(Blog.SubscribeOk)}}
        </div>

        <a class='btn btn-success' href='{{GetPath(/Blog)}}' >
            {{GetCode(Forum.ReturnToBlog)}}
        </a>

        {{/if Model->State = Updated}}
   
</section>