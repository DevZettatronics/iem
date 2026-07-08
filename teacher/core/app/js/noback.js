function nobackbutton()
{
   window.location.hash="rückwärts blockiert";
   window.location.hash="Again-No-back-button"
   window.onhashchange=function(){window.location.hash="rückwärts-blockiert";}   
}

