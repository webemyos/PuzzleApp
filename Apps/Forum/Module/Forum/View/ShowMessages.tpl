<section>
    <h2>{{GetCode(Forum.MessageOfCategory)}} : {{Category->Name->Value}}</h2>
    <p>
        <a href='{{GetPath(/Forum/NewDiscussion)}}' class='btn btn-success'  >{{GetCode(Forum.NewDiscussion)}}</a>
    </p>
    
    <table class='grid width100'>
        <tr>
            <th>{{GetCode(Forum.Sujet)}}</th>
            <th>{{GetCode(Forum.NbMessage)}}</th>
            <th>{{GetCode(Forum.LastReponse)}}</th>
        </tr>
        {{foreach Messages}}
        <td>
            <a href='{{GetPath(/Forum/Sujet/{{element->IdEntite}}/{{element->Title->Value}})}}'> 
                {{element->Title->Value}}
            </a>
        </td>
            <td>{{element->GetNumberReponse()}}</td>
            <td>{{element->GetLastReponse()}}</td>
            
         {{/foreach Messages}}
        
    </table>
    
</section