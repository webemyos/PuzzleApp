var Dom = function(){};

/**
 * Vérify and execute Call Back when the document is Ready
 */
Dom.IsReady = function(callback) {
    if(callback && typeof callback === 'function'){
       if(document.attachEvent == undefined) {
          document.addEventListener("DOMContentLoaded", function() {
             return callback();
          });
       } else {
          document.attachEvent("onreadystatechange", function() {
             if(document.readyState === "complete") {
                return callback();
             }
          });
       }
    } else {
       console.error('The callback is not a function!');
    }
 };

 /**
  * Appel les focntions lorsque le document est prêt
  */
 (function(document, window, domIsReady, undefined)
  {
    Dom.IsReady(function() {

        //Script Nedeed Init
      Dialog.Init();

    }
);
 })(document, window, Dom.IsReady);

