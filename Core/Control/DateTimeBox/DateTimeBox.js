var DateTimeBox = new DateTimeBox();

function DateTimeBox()
{
	 this.Init = function(control)
	{
            	$(control).datetimepicker({
                dateFormat:'dd/mm/yy',
                controlType: 'select',
            });
	};
        
        this.Focus = function(control)
        {
            var inputs = control.parentNode.getElementsByTagName("input");
            this.Init(inputs[0]);
        };
       
};