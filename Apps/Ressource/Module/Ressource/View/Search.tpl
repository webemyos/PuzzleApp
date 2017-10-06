
{{foreach}}
  <div>
      <h4>{{element->Title->Value}} </h4> 
      <p>{{element->Description->Value}}</p>
      <a target='_blank' href='http://Webemyos.com/{{element->Link->Value}}' >Lire l'article</a>
  </div>

{{/foreach}}