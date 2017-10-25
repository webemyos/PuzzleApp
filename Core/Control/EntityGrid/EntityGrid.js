var UserActionColumn=new UserActionColumn();

function UserActionColumn()
{
	this.DoAction = function (UserAction, sender, id)
	{
		document.forms[sender].UserAction.value = UserAction;
		document.forms[sender].IdEntity.value = id;
	    document.forms[sender].submit();
	};
};