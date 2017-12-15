<div class='global-sub-block'>
    <div class='row' class='borderBottom' >
        <div class='headerDownload' >
            <h1>Centre de télechargement </h1>
        </div>
    </div>
   
    <div>
        
        <h2>Les applications</h2>
        {{foreach}}
            <div class='row borderBottom'>
                <h3>{{element->Name->Value}}</h3>
                <div class='col-md-8'>
                   {{element->Description->Value}}
                </div>
                <div class='col-md-2'>
                    <a class='btn btn-success' href='{{GetPath(/Downloader/download/{{element->Code->Value}})}}'>Télécharger</a>
                </div>
            </div>
        {{/foreach}}
    </div>
    
    
    <div class='clear'></div>
</div>

