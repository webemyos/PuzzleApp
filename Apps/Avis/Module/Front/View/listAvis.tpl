

{{foreach}}

    {{GetCode(Avis.Author)}} : {{element->Name->Value}}

    <p>
        {{element->Avis->Value}}
    </p>
{{/foreach}}