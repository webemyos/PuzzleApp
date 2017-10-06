<h3>{{GetCode(EeTask.DetailProjet)}} : {{element->Title->Value}}</h3>

<div class='row mt'>

    <div class='col-lg-3 mt'>
        <div>
        <h4>{{GetCode(EeTask.Lot)}}</h4>
            <div id='lstParent'>
                parentTask
            </div>
            btnAddParent
        </div>
         <div>
            <h4>{{GetCode(EeTask.childTask)}}</h4>
            <div>Developpement front</div>
            <div>Developpement back</div>
        </div>
    </div>
    <div class='col-lg-9 mt' id='lstChild' >
    </div>
</div>