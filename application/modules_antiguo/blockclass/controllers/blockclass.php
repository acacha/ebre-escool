<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";
include "funciones.php";
global $data;

      class Blockclass extends skeleton_main { 

    public $body_header_view ='include/ebre_escool_body_header' ;

    public $body_header_lang_file ='ebre_escool_body_header' ;

    public $html_header_view ='include/ebre_escool_html_header' ;

    public $body_footer_view ='include/ebre_escool_body_footer' ; 
    
        public function load_header_data($active_menu){

              
            // CSS
            $header_data= $this->add_css_to_html_header_data(
                $this->_get_html_header_data(),
                    "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/tribal-timetable.css'));        
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"); 
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/bootstrap-switch.min.css'));
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/bootstrap.min.extracolours.css'));
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/horaris.css'));            

            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/ace-fonts.css'));
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/ace.min.css'));
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/ace-responsive.min.css'));
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/ace-skins.min.css'));
/*
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));              
*/



            // JAVASCRIPT
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/jquery-1.9.1.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/ui/1.10.3/jquery-ui.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/jquery.ba-resize.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-tooltip.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-collapse.js'));                
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal-shared.js'));        
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal-timetable.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-switch.min.js'));

            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-extra.min.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-elements.min.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace.min.js'));            

        $header_data['menu']= $active_menu;
            return $header_data;
    }
    function lock_unlock(){
            $active_menu = array();
            $active_menu['menu']='#blockaula';
            $active_menu['submenu1']='#blockclass';
            $header_data = $this->load_header_data($active_menu);
            $data = $this->buttoms();
            $this->_load_html_header($header_data);
            $this->_load_body_header();
            $this->load->view('blockclass',$data);
            $this->_load_body_footer();
        }

    //get techer's IP to show buttoms
        function buttoms(){
            $data['button_lock']="<button class=\"btn btn-lg btn-danger\"><i class=\"icon-lock\"></i>";
            $data['button_unlock']="<button class=\"btn btn-lg btn-purple\"><i class=\"icon-unlock\"></i>";

            //Get user IP
            $ip=$_SERVER['REMOTE_ADDR'];
            //Get firewall status
            $status=estado();
            $data['stat']=$status;
            //Teacher aula 20.2
           if($ip=="192.168.50.12"){

                    $data['lock']="<a href=\"?lock=20.2\">".$data['button_lock']."Bloquear aula 20.2</button></a>";
                    $data['unlock']="<a href=\"?unlock=20.2\">".$data['button_unlock']."Desbloquear aula 20.2</button></a>";
             
           //Teacher aula 20.3
            }elseif($ip=="192.168.50.13"){
               
                 $data['lock']="<a href=\"?lock=20.3\">".$data['button_lock']."Bloquear aula 20.3</button></a>";
                 $data['unlock']="<a href=\"?unlock=20.3\">".$data['button_unlock']."Desbloquear aula 20.3</button></a>";
             
               
           //Teacher  aula 20.4 
            }elseif($ip=="192.168.50.14"){
               
                  $data['lock']="<a href=\"?lock=20.4\">".$data['button_lock']."Bloquear aula 20.4</button></a>";
                  $data['unlock']="<a href=\"?unlock=20.4\">".$data['button_unlock']."Desbloquear aula 20.4</button></a>";
               
              
           //localhost
            }elseif($ip=="127.0.0.1"){

              $data['lock']="<a href=\"?lock=20.2\">".$data['button_lock']."Bloquear aula 20.2</button></a>"."&nbsp;&nbsp;&nbsp;".
                 "<a href=\"?lock=20.3\">".$data['button_lock']."Bloquear aula 20.3</button></a>"."&nbsp;&nbsp;&nbsp;".
                 "<a href=\"?lock=20.4\">".$data['button_lock']."Bloquear aula 20.4</button></a>";
              $data['unlock']="<a href=\"?unlock=20.2\">".$data['button_unlock']."Desbloquear aula 20.2</button></a>"."&nbsp;&nbsp;&nbsp;".
                 "<a href=\"?unlock=20.3\">".$data['button_unlock']."Desbloquear aula 20.3</button></a>"."&nbsp;&nbsp;&nbsp;".
                "<a href=\"?unlock=20.4\">".$data['button_unlock']."Desbloquear aula 20.4</button></a>";
            }
          return $data;
        }
        function commands(){
            $active_menu = array();
            $active_menu['menu']='#blockaula';
            $active_menu['submenu1']='#commands';
            $header_data = $this->load_header_data($active_menu);
            $data = $this->buttoms();
            $this->_load_html_header($header_data);
            $this->_load_body_header();
            $data['saludo']="Ejecutar";
            $this->load->view('commands',$data);
            $this->_load_body_footer();
        }
    

        



}
           


            
        
        
    
 
    
    


