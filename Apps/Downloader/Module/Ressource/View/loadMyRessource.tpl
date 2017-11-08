<div class='content-panel'>
    <table class='grid'>
        <tr>
            <th>{{GetCode(Downloader.Name)}}</th>
            <th>{{GetCode(Downloader.NumberContact)}}</th>
            <th></th>
        </tr>  
        {{foreach}}
            <tr>
                <td>{{element->Name->Value}}</td>
                <td><a href='#' onclick='DownloaderAction.LoadContact({{element->IdEntite}})' >{{element->GetNumberEmail()}}</a></td>
                <td>
                    {{GetControl(EditIcone,icEdit,{OnClick=DownloaderAction.ShowAddRessource({{element->IdEntite}})})}}
                    
                </td>
            </tr>
        {{/foreach}}
    </table>    
</div>    
