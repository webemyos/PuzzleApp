<h1>{{GetCode(Downloader.PrivateRessource)}}</h1>


{{GetForm({{GetPath(\Downloader\Download\absences.csv)}})}}

<h2>{{GetCode(Downloader.LetYouEmail)}}</h2>
<p>{{GetControl(EmailBox,TbEmail,{Required=true})}}</p>

{{GetControl(Submit,btnSubmit,{value=Download})}}

{{CloseForm()}}