/* =============================================================
 * ebre-escool.js v0.0.1
 * https://github.com/acacha/ebre-escool
 * =============================================================
 * Copyright 2014 Sergi Tur Badenas
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */

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