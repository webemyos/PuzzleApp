<section>
    <h1>{{Forum->Name->Value}}</h1>
    <p>{{Forum->Description->Value}}</p>
    
    <table class='grid width100'>
        <tr>
            <th>{{GetCode(Forum.Category)}}</th>
            <th>{{GetCode(Forum.Description)}}</th>
            <th>{{GetCode(Forum.NbMessage)}}</th>
            <th>{{GetCode(Forum.LastMessage)}}</th>
        </tr>
        {{foreach Category}}
            <tr>
                <td><a href='{{element->GetUrl()}}'
                       title='{{element->Name->Value}}' >
                        {{element->Name->Value}}</a>
                </td>
                <td>{{element->Description->Value}}</td>
                <td>{{element->GetNumberMessage()}}</td>
                <td>{{element->GetLinkLastMessage()}}</td>
                
            </tr>
        {{/foreach Category}}
    </table>
</section>