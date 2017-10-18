<div class='row'>

    <div>
        <h1>{{GetCode(Mooc.Mooc)}} :: {{Mooc->Name->Value}}</h1>    
        <p>{{Mooc->Description->Value}}</p>
    </div>
<div class='col-md-2'>
    {{foreach Lessons}}
        <ul>
            <li><a href='{{GetPath(/Mooc/Lesson/)}}{{element->Code->Value}}'>
                    {{element->Name->Value}}
                </a>
            </li>
        </ul>
    {{/foreach Lessons}}
</div>
<div class='col-md-10'>

    <h2>{{GetCode(Mooc.Lesson)}} {{Intro->Name->Value}}</h2>
    <p>{{Intro->Description->Value}}</p>
    <p>{{Intro->Content->Value}}</p>

</div>
     

</div>
