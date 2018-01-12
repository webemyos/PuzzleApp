<section>
      <h2>{{GetCode(Blog.Comment)}}</h2>

        {{if Model->State = Init}}
            {{RenderModel()}}
        {{/if Model->State = Init}}

        {{if Model->State = Updated}}

        <div class='success'>
          {{GetCode(Blog.SaveCommentOk)}}
        </div>

        {{/if Model->State = Updated}}
   
</section>