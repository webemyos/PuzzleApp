<div class='row-fluid span12'>
    <div class='span11' id='Tools'>
        {{btnInformation}}
        {{btnCompetence}}
        
        {{if IsAdmin == true}}
            {{btnAdmin}}
        {{/if IsAdmin == true}}
        
    </div>
    <div class="" id='dvDesktop'>
          <h4 class='blueOne'>{{GetCode(EeProfil.TitleHome)}}</h4>
            <p>{{GetCode(EeProfi.MessageHome)}}</p>
    </div>
</div>
