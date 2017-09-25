var JUserAction=new UserAction();

function UserAction()
{
	this.DoAction = function (UserAction, Arg, sender)
	{

		if(sender.form != null)
		{
	 	sender.form.UserAction.value = UserAction;
	    sender.form.Arg.value = Arg;

		if(sender.form.Sender != null)
			{sender.form.Sender.value = sender.value;}

		sender.form.submit();
		}
		else
		{
		//recuperation du formulaire
		var formBlock = sender.parentNode;
		while(formBlock.nodeName != "FORM")
		{
			formBlock = formBlock.parentNode;
		}

		formBlock.UserAction.value = UserAction;
		formBlock.Arg.Value = Arg;
		formBlock.Sender.Value = sender.value;
		formBlock.submit()
		}
	};
};