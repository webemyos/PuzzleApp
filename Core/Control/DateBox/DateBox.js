var DateBox = new DateBox();

function DateBox()
{
	this.Verify = function(control,exp,message)
	{
	};
        
        this.Init = function(control)
	{
            	$(control).datepicker({
                dateFormat:'dd/mm/yy'
            });
	};
        
        this.Focus = function(control)
        {
            var inputs = control.parentNode.getElementsByTagName("input");
            this.Init(inputs[0]);
        };
};