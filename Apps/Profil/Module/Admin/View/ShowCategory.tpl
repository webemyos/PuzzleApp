<div id='dvCategory'>
    {{GetControl(Button,btnAddCategory,{CssClass=btn btn-info,Value=AddCategory,OnClick=ProfilAction.ShowAddCategory()})}}


    <table class='grid'>
        <tr>
            <th>{{GetCode(Libelle)}}</th>
            <th></th>
        </tr>
        {{foreach Category}}
            <tr>
                <td>{{element->Name->Value}}</td>
                <td>
                    {{GetControl(EditIcone, icEdit,{OnClick=ProfilAction.ShowAddCategory({{element->IdEntite}})})}}
                </td>
            </tr>
        {{/foreach Category}}
    </table>
</div>