var EmailBox = new EmailBox();

function EmailBox()
{
	this.Verify = function(control,exp,message)
	{
		var Expression = new RegExp(exp);
		if(control.value.length!=0 && !Expression.test(control.value))
                {
			alert(message);
                        control.value = "";
                        control.innerHTML = "";
                }
	};
};