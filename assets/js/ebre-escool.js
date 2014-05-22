$(document).ready(function(){
    var menu_count = Object.keys(menu).length;
    
      $(".open").removeClass("open");      
      $(".active").removeClass("active");   

      if(menu_count>1){

        for(var i=0; i<=menu_count; i++)
        {
          if(i==0){
            $(menu['menu']).addClass("open active");
          } else if(i==menu_count) {
            $(menu['submenu'+i]).addClass("active");
          } else {
            $(menu['submenu'+i]).addClass("open active");
          }
        }

      } else {
        $(menu['menu']).addClass("active");
      }

  });