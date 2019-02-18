<h3>{{GetCode(User)}}</h3>

<div id='dvUser'>
    {{foreach}}
        <div class='commerce fournisseur lineFonce'>
            <div>{{element->User->Value->Email->Value}}
                <i class='icon-remove' onclick='EeCommerceAction.RemoveUserFournisseur(this, {{element->IdEntite}})'>&nbsp;</i>";
            </div>
        </div>
    {{/foreach}}
</div>

    {{tbContact}}

