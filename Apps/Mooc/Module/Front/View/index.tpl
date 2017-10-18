<div class='row'>
<h1>{{GetCode(Mooc.YourMooc)}}</h1>

     {{foreach Mooc}}
        <div class='col-md-4' >
           <h2>{{element->Name->Value}}</h2>

          
           <div class='col-md-6'>
                {{element->Description->Value}}
           </div>
           <div class='col-md-12'>
            <a href='{{GetPath(/Mooc/Mooc/)}}{{element->Code->Value}}'>{{GetCode(Mooc.StartMooc)}}</a>
          </div>
           <div class="clearfix"></div>
        </div>
        {{/foreach Mooc}}

</div>
