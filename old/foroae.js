(function() {
  var all = document.all;
  if(all) {
    var lst = [];
    var len = all.length;
    for(var i = 0; i < len; i++) {
      var obj = all[i];
      if(obj && obj.nodeName) {
        switch(obj.nodeName.toLowerCase()) {
          case "object":
          case "applet":
          case "embed":
            lst[lst.length] = obj;
            break;
          default:
        }
      }
    }
    for(var i = 0; i < lst.length; i++) {
      lst[i].outerHTML += "";
    }
    lst = null;
  }
})();

