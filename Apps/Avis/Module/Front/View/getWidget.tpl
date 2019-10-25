<section>

        <h2>{{GetCode(Avis.TheAvis)}}</h2>

        {{foreach Avis}}
    
          <i>{{element->DateCreated->Value}}</i>
            {{element->Name->Value}}

         <p>
            {{element->Avis->Value}}
         </p>
        {{/foreach Avis}}


    <h2>{{GetCode(Avis.LetYourAvis)}}</h2>
        {{if Model->State = Init}}
            {{RenderModel()}}
        {{/if Model->State = Init}}

        {{if Model->State = Updated}}

        <div class='success'>
          {{GetCode(Avis.AvisSaved)}}
        </div>

        {{/if Model->State = Updated}}
   
</section>