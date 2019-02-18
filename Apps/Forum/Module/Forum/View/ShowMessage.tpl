<section style='text-align:left'>
    <div id='dvMessage'>
        <table class='grid width100'>
            <tr>
                <th style='width:20%'></th>
                <th ><h3>{{Message->Title->Value}}</h3></th>
            </tr>
            <tr>
                <td>
                    <p>{{Message->DateCreated->Value}}</p>
                    
                    <p>{{Message->GetUser()}}</p>
                </td>
                <td>
                    <p>{{Message->Message->Value}}</p>
                </td>
            </tr>
            <tr>
                <th></th>
                <th><h3>{{GetCode(Forum.Reponse)}}</h3></th>
            </tr>
            {{foreach Reponses}}
                <tr>
                    <td>
                    {{element->GetUser()}}
                    {{element->DateCreated->Value}}</td>
                    <td>{{element->Message->Value}}</td>
                </tr>
               
            
            {{/foreach Reponses}}
        </table>
    </div>
        
    <div class='borderTop'>
        
        {{if Connected == true}}
        
            {{if Model->State = Init}}
                {{RenderModel()}}
            {{/if Model->State = Init}}

            {{if Model->State = Updated}}

                <div class='success'>
                  {{GetCode(Forum.MessageSaved)}}
                </div>

            {{/if Model->State = Updated}}
        {{/if Connected == true}}
        
        {{if Connected == false}}
        
             {{GetCode(Forum.MustBeConnected)}}
       
            <br/>
            <a class='btn btn-primary' href='{{GetPath(/singup)}}' >
                 {{GetCode(Singup)}}
             </a>
        
        {{/if Connected == false}}
        
    </div>    
</section>


<script>
    setTimeout(function(){console.log("ck"); Dashboard.SetBasicAdvancedText("Message")},200) ;
</script>