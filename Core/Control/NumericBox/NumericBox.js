var NumericBox = new NumericBox();

function NumericBox()
{
	this.Verify = function(control,exp,message)
	{
		var Expression = new RegExp(exp);
		if(!Expression.test(control.value))
			alert(message);
	};
};
