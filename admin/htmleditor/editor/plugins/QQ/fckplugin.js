
// Register the related command.
FCKCommands.RegisterCommand( 'QQ', new FCKDialogCommand( 'QQ', FCKLang.QQDlgTitle, FCKPlugins.Items['QQ'].Path + 'fck_qq.html', 300, 140 ) ) ;

var oQQItem = new FCKToolbarButton( 'QQ', FCKLang.QQBtn ) ;
oQQItem.IconPath = FCKPlugins.Items['QQ'].Path + 'qq.gif' ;

FCKToolbarItems.RegisterItem( 'QQ', oQQItem ) ;

var FCKQQs = new Object() ;

FCKQQs.Add = function( number )
{
	var qqLink = FCK.InsertElement( 'a' );
	qqLink.href = 'http://wpa.qq.com/msgrd?V=1&Uin='+ number +'&amp;Site=[Site]&amp;Menu=yes';
	qqLink.innerHTML = '<img alt="QQ:'+ number +'" src="http://wpa.qq.com/pa?p=1:'+ number +':1" border="0">';
}