<section>

       {{if Model->State = Init}}
            <h2>{{GetCode(Avis.DeposeAvis)}}</h2>

            {{RenderModel()}}
        {{/if Model->State = Init}}

        {{if Model->State = Updated}}

        <div class='success'>
          {{GetCode(Avis.AvisSaved)}}
        </div>

        {{/if Model->State = Updated}}
   
</section>