<div class='flex'>
	<div class='col_9 alignCenter'>
        !tbName <br/>
        
       Partagé :  !cbShared
        
        </div>
        <div id='dvField'>
            <h3 style='display:inline;color:blue' >!field</h3>
            <b class='fa fa-edit' onclick='IdeElement.ShowTableElement("taField")'>&nbsp</b>
            <b class='fa fa-plus' onclick='IdeElement.AddField("taField")'>&nbsp</b>
            <br/>
            <table id='taField'>
                <tr>
                    <th>Name</th><th>Type</th><th>Null</th>
                </tr>
            </table>
        </div>
        <div id='dvKey'>
            <h3 style='display:inline;color:green'>!Key</h3>
            <b class='fa fa-edit' onclick='IdeElement.ShowTableElement("taKey")'>&nbsp</b>
             <b class='fa fa-plus' onclick='IdeElement.AddKey("taKey")'>&nbsp</b><br/>
            <table id='taKey'>
                <tr>
                    <th>Base.Entite</th><th>Base.Field</th><th>Field</th>
                </tr>
            </table>
        </div>
        <div class='alignCenter' id='dvResultEntity'>
        </div>
        !btnCreate
</div>    

