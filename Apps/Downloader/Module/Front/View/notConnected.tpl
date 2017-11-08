<h1>{{GetCode(Downloader.PrivateRessource)}}</h1>


{{GetForm(\Downloader\Download\{{element->Code->Value}})}}

    <h2>{{GetCode(Downloader.LetYouEmail)}}</h2>
    <p>{{GetControl(EmailBox,email,{Required=true})}}</p>

    {{GetControl(Submit,btnSubmit,{value=Download})}}

{{CloseForm()}}