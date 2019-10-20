{{if Model->State = Init}}
    {{RenderModel()}}
 {{/if Model->State = Init}}

 {{if Model->State = Updated}}

    <div class='success'>
      {{GetCode(Feedback.FeedbackSaved)}}
    </div>

 {{/if Model->State = Updated}}