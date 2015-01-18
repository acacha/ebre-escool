<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class attendance extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php';
	//public $html_header_view ='/include/ebre_escool_html_header.php';

	public $body_header_lang_file ='ebre_escool_body_header' ;

	public $html_header_view ='include/ebre_escool_html_header' ;
	public $body_footer_view ='include/ebre_escool_body_footer' ;

	public function load_header_data_datatables_10($menu = false){
		$active_menu = $menu;

		//CSS URLS
		$jquery_ui_css_url = "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
		$jquery_ui_editable_css_url = "http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css";
		$select2_css_url = "http://cdn.jsdelivr.net/select2/3.4.5/select2.css";
		//JS URLS
		$jquery_url= "http://code.jquery.com/jquery-1.9.1.js";
		$jquery_ui_url= "http://code.jquery.com/ui/1.10.3/jquery-ui.js";
		$select2_url= "http://cdn.jsdelivr.net/select2/3.4.5/select2.js";
		$jquery_ui_editable_url= "http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js";

		if (defined('ENVIRONMENT') && ENVIRONMENT=="development") {
  			$jquery_ui_css_url = base_url('assets/css/jquery-ui.css');
  			$jquery_ui_editable_css_url = base_url('assets/css/jqueryui-editable.css');
  			$select2_css_url = base_url('assets/css/select2.css');

  			//$jquery_url= base_url('assets/js/jquery-1.9.1.js');
  			$jquery_url= base_url('assets/js/jquery-1.10.2.min.js');
			$jquery_ui_url= base_url('assets/js/jquery-ui.js');
			$select2_url= base_url('assets/js/select2.js');
			$jquery_ui_editable_url= base_url('assets/js/jqueryui-editable.min.js');
		}

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			$jquery_ui_css_url);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			$jquery_ui_editable_css_url);

		$header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/datepicker.css'));  

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			$select2_css_url);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
            base_url('assets/css/tribal-timetable.css')); 

		
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap-switch.min.css'));


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap.min.extracolours.css')); 

//ACE
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
        $header_data = $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery.gritter.css'));

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/css/jquery_plugins/fancybox/jquery.fancybox.css'));

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/dataTables.colReorder.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/dataTables.colVis.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/daterangepicker.css'));

/*        
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));        


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/chosen.min.css'));        

		//JS Already load at skeleton main!!!
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_url);
*/
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_ui_url);	


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$select2_url);


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_ui_editable_url);


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.js'));


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.ca.js'));


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.es.js'));


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
            "http://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js");

        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/dataTables.colReorder.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/dataTables.colVis.js'));


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.bootstrap.js'));


        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-switch.min.js'));

 //ACE        
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace.min.js'));
                    
/*
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/chosen.jquery.min.js'));
*/

		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/grocery_crud/js/jquery_plugins/jquery.fancybox-1.3.4.js'));
		$header_data= $this->add_javascript_to_html_header_data(
        			$header_data,
        			base_url('assets/js/jquery.gritter.min.js')); 

		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));
        
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/jquery.easy-pie-chart.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/flot/jquery.flot.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/flot/jquery.flot.pie.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/jquery.sparkline.min.js'));        
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/date-time/moment.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/date-time/daterangepicker.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/date-time/locales/bootstrap-datepicker.ca.js'));
    
        
		$header_data['menu']= $active_menu;
		return $header_data; 
	}

	public function load_header_data($menu = false){

		$active_menu = $menu;

		//CSS URLS
		$jquery_ui_css_url = "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
		$jquery_ui_editable_css_url = "http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css";
		$select2_css_url = "http://cdn.jsdelivr.net/select2/3.4.5/select2.css";
		//JS URLS
		$jquery_url= "http://code.jquery.com/jquery-1.9.1.js";
		$jquery_ui_url= "http://code.jquery.com/ui/1.10.3/jquery-ui.js";
		$select2_url= "http://cdn.jsdelivr.net/select2/3.4.5/select2.js";
		$jquery_ui_editable_url= "http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js";

		if (defined('ENVIRONMENT') && ENVIRONMENT=="development") {
  			$jquery_ui_css_url = base_url('assets/css/jquery-ui.css');
  			$jquery_ui_editable_css_url = base_url('assets/css/jqueryui-editable.css');
  			$select2_css_url = base_url('assets/css/select2.css');

  			//$jquery_url= base_url('assets/js/jquery-1.9.1.js');
  			$jquery_url= base_url('assets/js/jquery-1.10.2.min.js');
			$jquery_ui_url= base_url('assets/js/jquery-ui.js');
			$select2_url= base_url('assets/js/select2.js');
			$jquery_ui_editable_url= base_url('assets/js/jqueryui-editable.min.js');
		}

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			$jquery_ui_css_url);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			$jquery_ui_editable_css_url);

		$header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/datepicker.css'));  

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			$select2_css_url);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
            base_url('assets/css/tribal-timetable.css')); 

		
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap-switch.min.css'));


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap.min.extracolours.css')); 

//ACE
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
        $header_data = $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery.gritter.css'));

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/css/jquery_plugins/fancybox/jquery.fancybox.css'));

/*        
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));        


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/chosen.min.css'));        
*/
		//JS Already load at skeleton main!!!
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_url);

		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_ui_url);	


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$select2_url);


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_ui_editable_url);


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.js'));


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.ca.js'));


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.es.js'));


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
            base_url('assets/js/jquery.dataTables.min.js'));


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.bootstrap.js'));


        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-switch.min.js'));

 //ACE        
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace.min.js'));
                    
/*
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/chosen.jquery.min.js'));
*/

		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/grocery_crud/js/jquery_plugins/jquery.fancybox-1.3.4.js'));
		$header_data= $this->add_javascript_to_html_header_data(
        			$header_data,
        			base_url('assets/js/jquery.gritter.min.js')); 

		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));


		$header_data['menu']= $active_menu;
		return $header_data; 
        
    }

    public function load_header_data_11($menu = false){

        $active_menu = $menu;

        //CSS URLS
        $jquery_ui_css_url = "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
        $jquery_ui_editable_css_url = "http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css";
        $select2_css_url = "http://cdn.jsdelivr.net/select2/3.4.5/select2.css";
        //JS URLS
        $jquery_url= "http://code.jquery.com/jquery-1.9.1.js";
        $jquery_ui_url= "http://code.jquery.com/ui/1.10.3/jquery-ui.js";
        $select2_url= "http://cdn.jsdelivr.net/select2/3.4.5/select2.js";
        $jquery_ui_editable_url= "http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js";

        if (defined('ENVIRONMENT') && ENVIRONMENT=="development") {
            $jquery_ui_css_url = base_url('assets/css/jquery-ui.css');
            $jquery_ui_editable_css_url = base_url('assets/css/jqueryui-editable.css');
            $select2_css_url = base_url('assets/css/select2.css');

            //$jquery_url= base_url('assets/js/jquery-1.9.1.js');
            $jquery_url= base_url('assets/js/jquery-1.10.2.min.js');
            $jquery_ui_url= base_url('assets/js/jquery-ui.js');
            $select2_url= base_url('assets/js/select2.js');
            $jquery_ui_editable_url= base_url('assets/js/jqueryui-editable.min.js');
        }

        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            $jquery_ui_css_url);

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            $jquery_ui_editable_css_url);

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/datepicker.css'));  

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            $select2_css_url);

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/tribal-timetable.css')); 

        
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap-switch.min.css'));


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap.min.extracolours.css')); 

//ACE
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
        $header_data = $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery.gritter.css'));

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/css/jquery_plugins/fancybox/jquery.fancybox.css'));

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/dataTables.colReorder.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/dataTables.colVis.css'));

/*        
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));        


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/chosen.min.css'));        
*/
        //JS Already load at skeleton main!!!
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            $jquery_url);

        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            $jquery_ui_url);    


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            $select2_url);


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            $jquery_ui_editable_url);


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-datepicker.js'));


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-datepicker.ca.js'));


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-datepicker.es.js'));


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
            base_url('assets/js/jquery.dataTables.min.js'));


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.bootstrap.js'));


        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-switch.min.js'));

 //ACE        
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace.min.js'));
                    
/*
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/chosen.jquery.min.js'));
*/

        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/grocery_crud/js/jquery_plugins/jquery.fancybox-1.3.4.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/jquery.gritter.min.js')); 

        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/dataTables.colReorder.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/dataTables.colVis.js'));

        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));


        $header_data['menu']= $active_menu;
        return $header_data; 
        
    }


	function __construct()
    {
        parent::__construct();
        
        $this->load->model('attendance_model');
        $this->load->library('ebre_escool_ldap');

        $this->load->library('ebre_escool');

        //GROCERY CRUD
		$this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
		$this->load->library('image_CRUD');  

		/* Set language */
		$current_language=$this->session->userdata("current_language");
		if ($current_language == "") {
			$current_language= $this->config->item('default_language','skeleton_auth');
		}
		$this->grocery_crud->set_language($current_language);
    	$this->lang->load('skeleton', $current_language);	       
    	
    	$this->lang->load('attendance', $current_language);	
    	
		$this->lang->load('managment', $current_language);        
        
	}


	/*
	TODO: remove

	public function read($table=null){

		$this->db->select('alumne, incidencia, data, hora');
		$this->db->where('alumne', $_POST['alumne']); 
		$this->db->where('hora', $_POST['hora']);
		$query = $this->db->get($table);
		$resultat = array();
		$resultat[] = "Alumne  - Incidencia - Data - Hora";

		foreach ($query->result() as $row)
		{
		    $resultat[] = $row->alumne ." - ".$row->incidencia." - ".$row->data." - ".$row->hora;
		}
		print_r(json_encode($resultat));
	}	

	public function insert($table=null){

		//echo $table;
		$this->db->insert($table, $_POST); 
		$rows = $this->db->affected_rows();
		print_r(json_encode($this->db->affected_rows()));
		//$this->db->insert($table, $data); 
		//print_r(json_encode($data));
	}		

	public function update(){

		$data = array(
           'cycle_shortname' => 'cic mod 1',
           'cycle_name' => 'cicle modificat 1',
           'cycle_entryDate' => date("Y-m-d H:i:s")
        );

		$this->db->where('cycle_id', '6');
		$this->db->update('cycle', $data); 
		print_r(json_encode($data));
	}	

	public function delete(){
		$data = array(
			'Esborrat' => 'id 8'		
		);
		$this->db->where('cycle_id', '8');
		$this->db->delete('cycle'); 
		print_r(json_encode($data));
	}

	fi proves ajax json */	 



	public function crud_incidence () {

		/*
		person_id : person_id,
        time_slot_id : time_slot_id,
        day : day,
        date: date,
        study_submodule_id: study_submodule_id,
        absence_type : selected_value 
		*/

        $result = new stdClass();
        $result->result = false;
        $result->message = "No enough values especified!";

		$error = false;
		$person_id = "";
	    if(isset($_POST['person_id'])) {
        	$person_id = $_POST['person_id'];
	    } else {
	    	$error = true;
	    }

	    $time_slot_id = "";
	    if(isset($_POST['time_slot_id'])) {
        	$time_slot_id = $_POST['time_slot_id'];
	    } else {
	    	$error = true;
	    }

	    $day = "";
	    if(isset($_POST['day'])) {
        	$day = $_POST['day'];
	    } else {
	    	$error = true;
	    }

	    $date = "";
	    if(isset($_POST['date'])) {
        	$date = $_POST['date'];
	    } else {
	    	$error = true;
	    }

	    $study_submodule_id = "";
	    if(isset($_POST['study_submodule_id'])) {
        	$study_submodule_id = $_POST['study_submodule_id'];
	    } else {
	    	$error = true;
	    }

	    $absence_type = "";
	    if(isset($_POST['absence_type'])) {
        	$absence_type = $_POST['absence_type'];
	    } else {
	    	$error = true;
	    }

	    if (!$error) {
	    	if ( ($person_id != "") && ($time_slot_id != "") && ($day != "") && ($date != "") && ($study_submodule_id != "") && ($absence_type != "") )
	    	$result = $this->attendance_model->crud_incidence($person_id,$time_slot_id,$day,$date,$study_submodule_id,$absence_type);	
	    }

	    print_r(json_encode($result));

	}

	public function get_incidents_statistics_by_student($student_id=null,$classroom_group_id=null,$initial_date=null,$final_date=null) {
		if  ($student_id==null) {
			if(isset($_POST['student_id'])) {
	        	$student_id = $_POST['student_id'];
			}
		}

        if  ($classroom_group_id==null) {
            if(isset($_POST['classroom_group_id'])) {
                $classroom_group_id = $_POST['classroom_group_id'];
            }
        }

        if  ($initial_date==null) {
            if(isset($_POST['initial_date'])) {
                $initial_date = $_POST['initial_date'];
            }
        }

        if  ($final_date==null) {
            if(isset($_POST['final_date'])) {
                $final_date = $_POST['final_date'];
            }
        }

		$result = new stdClass();
		if ($student_id != null) {
			$result = $this->attendance_model->get_incidents_statistics_by_student($student_id,$classroom_group_id,$initial_date,$final_date);	
		}

		print_r(json_encode($result));
	}

	public function create_test_incidents_managment_by_ajax() {
		$data = array();
        $this->load->view('create_test_incidents_managment_by_ajax.php',$data); 
	}

	/*
	OBSOLET!
	*/
	public function insert_incidents() {

		if (!$this->skeleton_auth->logged_in())	{
			//TODO check permisions!
        	echo "User not logged";
    	}

		//TODO: validate data	

    	$this->attendance_model->insert_incidence($_POST);

	}
	
	public function test_incidents_managment_by_ajax () {	
		
		$active_menu = array();
		$active_menu['menu']='#maintenances';
		$active_menu['submenu1']='#attendance_managment';
		$active_menu['submenu2']='#time_slots';

	    $this->check_logged_user();

		/* Ace */
	    $header_data = $this->load_ace_files($active_menu); 

		// HTML HEADER
        $this->_load_html_header($header_data); 
        $this->_load_body_header();      
       
       	// BODY       
       	$data = array();
        $this->load->view('test_incidents_managment_by_ajax.php',$data); 

	}

	public function hidden_students() {
		$active_menu = array();
		$active_menu['menu']='#maintenances';
		$active_menu['submenu1']='#attendance_maintainance';
		$active_menu['submenu2']='#hidden_students';

	    $this->check_logged_user();

		/* Ace */
	    $header_data = $this->load_ace_files($active_menu);  

	    // Grocery Crud 
	    $this->current_table="hidden_student";
	    $this->grocery_crud->set_table($this->current_table);
	        
	    $this->session->set_flashdata('table_name', $this->current_table);     
			
		//Establish subject:
	    $this->grocery_crud->set_subject(lang("hidden_students"));

	    //COMMON_COLUMNS               
	    $this->set_common_columns_name($this->current_table);       

	    $this->common_callbacks($this->current_table);

	    $this->grocery_crud->display_as($this->current_table.'_id',lang($this->current_table . '_id'));
	    $this->grocery_crud->display_as($this->current_table.'_person_id',lang($this->current_table . '_person_id'));     
	    $this->grocery_crud->display_as($this->current_table.'_teacher_id',lang($this->current_table . '_teacher_id'));
	    $this->grocery_crud->display_as($this->current_table.'_academic_period_id',lang($this->current_table . '_academic_period_id'));
	    $this->grocery_crud->display_as($this->current_table.'_classroom_group_id',lang($this->current_table . '_classroom_group_id'));
	    $this->grocery_crud->display_as($this->current_table.'_study_module_id',lang($this->current_table . '_study_module_id'));
	    $this->grocery_crud->display_as($this->current_table.'_study_submodule_id',lang($this->current_table . '_study_submodule_id'));
	    $this->grocery_crud->display_as($this->current_table.'_day_id',lang($this->current_table . '_day_id'));


	    $this->grocery_crud->display_as($this->current_table.'_entryDate',lang($this->current_table . '_entryDate'));
	    $this->grocery_crud->display_as($this->current_table.'_last_update',lang($this->current_table . '_last_update'));
	    $this->grocery_crud->display_as($this->current_table.'_lastupdateUserId',lang($this->current_table . '_lastupdateUserId'));
	    $this->grocery_crud->display_as($this->current_table.'_markedForDeletion',lang($this->current_table . '_markedForDeletion'));
	    $this->grocery_crud->display_as($this->current_table.'_markedForDeletionDate',lang($this->current_table . '_markedForDeletionDate'));

	    //RELATIONS
	    $this->grocery_crud->set_relation($this->current_table.'_academic_period_id','academic_periods','{academic_periods_shortname}'); 
	    $this->grocery_crud->set_relation($this->current_table.'_person_id','person','{person_sn1} {person_sn2}, {person_givenName} ({person_official_id}) - {person_id}');
	    $this->grocery_crud->set_relation($this->current_table.'_teacher_id','teacher','id: {teacher_id} - person_id: {teacher_person_id} - user_id: {teacher_user_id}');
	    $this->grocery_crud->set_relation($this->current_table.'_classroom_group_id','classroom_group','{classroom_group_code} - {classroom_group_shortName}. {classroom_group_name} ({classroom_group_id})');
	    $this->grocery_crud->set_relation($this->current_table.'_study_module_id','study_module','{study_module_shortname}. {study_module_name} ({study_module_id})');
	    $this->grocery_crud->set_relation($this->current_table.'_study_submodule_id','study_submodules','{study_submodules_shortname}. {study_submodules_name} ({study_submodules_id})');
	    //$this->grocery_crud->set_relation($this->current_table.'_day_id','teacher','id: {teacher_id} - person_id: {teacher_person_id} - user_id: {teacher_user_id}');


	    //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
	    
	    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
			
	    $this->userCreation_userModification($this->current_table);

	    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

	    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

		$this->renderitzar($this->current_table,$header_data);			
	}

	public function time_slots () {

		$active_menu = array();
		$active_menu['menu']='#maintenances';
		$active_menu['submenu1']='#attendance_maintainance';
		$active_menu['submenu2']='#time_slots';

	    $this->check_logged_user();

		/* Ace */
	    $header_data = $this->load_ace_files($active_menu);  

	    // Grocery Crud 
	    $this->current_table="time_slot";
	    $this->grocery_crud->set_table($this->current_table);
	        
	    $this->session->set_flashdata('table_name', $this->current_table);     
			
		//Establish subject:
	    $this->grocery_crud->set_subject(lang("time_slot"));

	    //COMMON_COLUMNS               
	    $this->set_common_columns_name($this->current_table);       

	    $this->common_callbacks($this->current_table);

	    //ESPECIFIC COLUMNS  
	    $this->grocery_crud->display_as($this->current_table.'_id',lang('time_slot_id'));
	    $this->grocery_crud->display_as($this->current_table.'_external_code',lang('time_slot_external_code'));
	    $this->grocery_crud->display_as($this->current_table.'_start_time',lang('time_slot_start_time'));       
	    $this->grocery_crud->display_as($this->current_table.'_end_time',lang('time_slot_end_time'));       

	    //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
	    
	    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
			
	    $this->userCreation_userModification($this->current_table);

	    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

	    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

		$this->renderitzar($this->current_table,$header_data);	

	}

	public function incident () {

		$active_menu = array();
		$active_menu['menu']='#maintenances';
		$active_menu['submenu1']='#attendance_maintainance';
		$active_menu['submenu2']='#attendance_incident';

	    $this->check_logged_user();

		/* Ace */
	    $header_data = $this->load_ace_files($active_menu);  

	    // Grocery Crud 
	    $this->current_table="incident";
	    $this->grocery_crud->set_table($this->current_table);
	        
	    $this->session->set_flashdata('table_name', $this->current_table);     
			
		//Establish subject:
	    $this->grocery_crud->set_subject(lang("incident"));

	    //COMMON_COLUMNS               
	    $this->set_common_columns_name($this->current_table);       

	    $this->common_callbacks($this->current_table);

	    $this->grocery_crud->columns($this->current_table."_id",$this->current_table.'_student_id', $this->current_table.'_day', $this->current_table.'_date',
	    	$this->current_table.'_time_slot_id', $this->current_table.'_study_submodule_id', $this->current_table.'_type',
	    	$this->current_table.'_notes',
	    	$this->current_table.'_entryDate',$this->current_table.'_last_update',
	    	$this->current_table."_creationUserId",$this->current_table."_lastupdateUserId", $this->current_table.'_markedForDeletion',
	    	$this->current_table.'_markedForDeletionDate');

	    //ESPECIFIC COLUMNS  
	    $this->grocery_crud->display_as($this->current_table.'_student_id',lang('student'));
	    $this->grocery_crud->display_as($this->current_table.'_day',lang('day'));
	    $this->grocery_crud->display_as($this->current_table.'_day',lang('date'));
	    $this->grocery_crud->display_as($this->current_table.'_time_slot_id',lang('time_slot'));
	    $this->grocery_crud->display_as($this->current_table.'_study_submodule_id',lang('study_submodule'));
	    $this->grocery_crud->display_as($this->current_table.'_type',lang('incident_type'));
	    $this->grocery_crud->display_as($this->current_table.'_notes',lang('incident_notes'));
	    
	    //Relations
    	$this->grocery_crud->set_relation($this->current_table.'_student_id','person','{person_id} - {person_sn1} {person_sn2}, {person_givenName} - {person_official_id}',array('student_markedForDeletion' => 'n'));
    	$this->grocery_crud->set_relation($this->current_table.'_time_slot_id','time_slot','{time_slot_start_time} - {time_slot_end_time}',array('time_slot_markedForDeletion' => 'n'));
		$this->grocery_crud->set_relation($this->current_table.'_study_submodule_id','study_submodules','{study_submodules_id} - {study_submodules_name}',array('study_submodules_markedForDeletion' => 'n'));
    	$this->grocery_crud->set_relation($this->current_table.'_type','incident_type','{incident_type_id} - {incident_type_shortName}',array('incident_type_markedForDeletion' => 'n'));

	    //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
	    
	    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
			
	    $this->userCreation_userModification($this->current_table);

	    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

	    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

		$this->renderitzar($this->current_table,$header_data);	

	}

	public function incident_type () {

		$active_menu = array();
		$active_menu['menu']='#maintenances';
		$active_menu['submenu1']='#attendance_maintainance';
		$active_menu['submenu2']='#attendance_incident_type';

	    $this->check_logged_user();

		/* Ace */
	    $header_data = $this->load_ace_files($active_menu);  

	    // Grocery Crud 
	    $this->current_table="incident_type";
	    $this->grocery_crud->set_table($this->current_table);
	        
	    $this->session->set_flashdata('table_name', $this->current_table);     
			
		//Establish subject:
	    $this->grocery_crud->set_subject(lang("incident_type"));

	    //COMMON_COLUMNS               
	    $this->set_common_columns_name($this->current_table);       

	    $this->common_callbacks($this->current_table);

	    //ESPECIFIC COLUMNS  
	    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
	    $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName'));
	    $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));
	    $this->grocery_crud->display_as($this->current_table.'_code',lang('code'));
	    $this->grocery_crud->display_as($this->current_table.'_order',lang('order'));
	    
	    //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
	    
	    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
			
	    $this->userCreation_userModification($this->current_table);

	    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

	    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

		$this->renderitzar($this->current_table,$header_data);	

	}

	
	public function mentoring_groups ( $class_room_group_id = null, $teacher_code = null, $academic_period_id = null ) {

		if ($academic_period_id == null ) {
			$academic_period_id = $this->attendance_model->get_current_academic_period_id();
		}

		$active_menu = array();
		$active_menu['menu']='#mentoring';
		$active_menu['submenu1']='#mentoring_groups';

    	$this->check_logged_user();

    	$user_is_admin = $this->ebre_escool->user_is_admin();
    	$data['user_is_admin'] = $user_is_admin;

    	$person_id = $this->session->userdata('person_id');

    	$user_is_a_teacher = $this->attendance_model->is_user_a_teacher($person_id);
		$data['is_teacher'] = $user_is_a_teacher;

		if ($user_is_a_teacher) {
			$user_teacher_code = $this->attendance_model->get_teacher_code_by_personid($person_id);        
        	$user_teacher_id = $this->attendance_model->get_teacher_id_by_personid($person_id);
		}
        
        $teacher_id = null;
        if ($teacher_code == null) {
            $teacher_id = $user_teacher_id;
            $teacher_code = $user_teacher_code;
        } else {
            if (!$user_is_admin) { 
                $teacher_id = $user_teacher_id; 
                $teacher_code = $user_teacher_code;
            } 
        }
    	
    	$teachers_array = array();
    	$data['teachers'] = array();
    	if ($user_is_admin) {
            //Load teachers from Model
            $teachers_array = $this->attendance_model->get_all_teachers_ids_and_names();
            $data['teachers'] = $teachers_array;
        } else {
            //Show Only one teacher
            $teachers_array = $this->attendance_model->get_teacher_ids_and_names_by_teacher_code($teacher_code);
            $data['teachers'] = $teachers_array;
        }

        //var_export($data['teachers']);

        $data['default_teacher_code'] = $teacher_code;
        $data['default_teacher'] = $teacher_code;
        $data['default_teacher_id'] = $teacher_id;

		$header_data = $this->load_header_data($active_menu);

        $this->_load_html_header($header_data);
		
		$this->_load_body_header();

		//Check if user is manager -> Show all groups

		// IF USER IS NOT MANAGER -> IS MENTOR? -> SHOW GROUPS user is mentor
		$is_mentor = $this->attendance_model->is_mentor($this->session->userdata('teacher_id'));

		$mentor_id = 0;
		$default_classroom_group_id = 0;
		if ($is_mentor) {
			$mentor_id = $this->session->userdata('teacher_id');	
			$default_classroom_group_id = $this->attendance_model->get_first_classroom_group_id_ismentor($this->session->userdata('teacher_id'));
		} else {
			$default_classroom_group_id = $this->attendance_model->get_first_classroom_group_id($this->session->userdata('teacher_id'));
		}


		
		$data['is_mentor'] = $is_mentor;
		$data['mentor_id'] = $mentor_id;

		$data['default_classroom_group_id'] = $default_classroom_group_id;
		if ( $class_room_group_id != null ) {
			$data['default_classroom_group_id'] = $class_room_group_id;			
		}

		$data['check_attendance_date'] = date('d/m/Y');

		

		$all_classgroups = array();

		if ($user_is_admin) { 
			$all_classgroups = $this->attendance_model->get_all_groups();
		} else {
			if ($is_mentor) {
				$all_classgroups = $this->attendance_model->get_all_groups_by_mentor_id($academic_period_id,$mentor_id); 
			}
		}

		$data['classroom_groups'] = $all_classgroups;		
		
		$data['classroom_groups'] = 

		$this->load->view('mentoring_groups',$data);	

		$this->_load_body_footer();		

	}

    public function mentoring_attendance_by_student ($academic_period_id = null, $student_id=null,$classroom_group_id=null) {

		$active_menu = array();
		$active_menu['menu']='#mentoring';
		$active_menu['submenu1']='#mentoring_attendance_by_student';

    	$this->check_logged_user();

		$header_data = $this->load_header_data_datatables_10($active_menu);
        $this->_load_html_header($header_data);

		$this->_load_body_header();

		if ($academic_period_id == null) {
            $academic_period_id = $this->attendance_model->get_current_academic_period_id();
        }

        $academic_periods = $this->attendance_model->get_all_academic_periods();

        $data = array();

        $data['academic_periods'] = $academic_periods;
        $data['selected_academic_period_id'] = $academic_period_id;

        

        $students_array = $this->attendance_model->get_students($academic_period_id);
        $data['students'] = $students_array;

        $data['default_student_key'] = 0;
        if ($student_id != null) {
            $data['default_student_key'] = $student_id;
        }

        $data['classroom_group_id'] = 0;
        if ($classroom_group_id != null) {
            $data['classroom_group_id'] = $classroom_group_id;
        }

        $incident_types = $this->attendance_model->get_incident_types();
        $data['incident_types'] = $incident_types;

		$this->load->view('mentoring_attendance_by_student',$data);	

		$this->_load_body_footer();		
	}

	public function pdf_exemple() {
		$this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
		#$this->load->library('fpdf');
		$this->load->library('fpdf');
		
        $pdf = new FPDF('P', 'mm', 'A4','font/');
		
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Image('http://fpdf.org/logo.gif');
		$pdf->Cell(0,10,utf8_decode('¡Hola, Món!'),1,2,'L');
		$pdf->Output();
	}




	public function classroom_groups() {

	$active_menu = array();
	$active_menu['menu']='#maintenances';
	$active_menu['submenu1']='#attendance_managment';
	$active_menu['submenu2']='#classroom_groups';
	
	//Cargar la llibreria fpdf
	$this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
	#$this->load->library('fpdf');
	$this->load->library('pdf');
	$pdf=new PDF();

    $this->check_logged_user();

	/* Ace */
    $header_data = $this->load_ace_files($active_menu);  	

    // Grocery Crud 
	$this->current_table="classroom_group";
    $this->grocery_crud->set_table($this->current_table);
    $this->session->set_flashdata('table_name', $this->current_table);

    //ESTABLISH SUBJECT        
    $this->grocery_crud->set_subject(lang('ClassroomGroup'));

    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);

	//Mandatory fields
    $this->grocery_crud->required_fields($this->current_table.'_code',$this->current_table.'_name',$this->current_table.'_shortName',$this->current_table.'_markedForDeletion');
        
    //express fields
    $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortName',$this->current_table.'_code');


    $this->grocery_crud->display_as($this->current_table.'_id',lang('idGroup'));
    $this->grocery_crud->display_as($this->current_table.'_code',lang('GroupCode'));
    $this->grocery_crud->display_as($this->current_table.'_course_id',lang('idCurs'));
    $this->grocery_crud->display_as($this->current_table.'_location_id',lang('location_id'));
    $this->grocery_crud->display_as($this->current_table.'_shift',lang('shift'));
	$this->grocery_crud->display_as($this->current_table.'_shortName',lang('GroupShortName'));
	$this->grocery_crud->display_as($this->current_table.'_name',lang('GroupName'));
	$this->grocery_crud->display_as($this->current_table.'_description',lang('GroupDescription'));
	$this->grocery_crud->display_as($this->current_table.'_educationalLevelId',lang('EducationalLevelId'));
	$this->grocery_crud->display_as($this->current_table.'_mentorId',lang('MentorId'));
    $this->grocery_crud->display_as($this->current_table.'_parentLocation',lang('parentLocation'));      		


    $this->common_callbacks($this->current_table);
        
    //UPDATE AUTOMATIC FIELDS
	$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
	$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
   	$this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
   	//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
    $this->grocery_crud->set_relation($this->current_table.'_creationUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_creationUserId',$this->session->userdata('user_id'));

    //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
    $this->grocery_crud->set_relation($this->current_table.'_lastupdateUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_lastupdateUserId',$this->session->userdata('user_id'));
        
    $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId',$this->current_table.'_parentLocation');
        
    $this->set_theme($this->grocery_crud);
    $this->set_dialogforms($this->grocery_crud);
        
    //Default values:
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_parentLocation',1);
        
	/* show only specified columns */
	$this->grocery_crud->columns($this->current_table.'_id',$this->current_table.'_code',$this->current_table.'_shortName',$this->current_table.'_name',$this->current_table.'_description',$this->current_table.'_mentorId',$this->current_table.'_entryDate',$this->current_table.'_last_update',$this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

    //markedForDeletion
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

	$this->renderitzar($this->current_table,$header_data);	

	}

	protected function getTimeSlotKeyByTimeSlotId($time_slots,$time_slot_id) {
		foreach ($time_slots as $time_slot_key => $time_slot) {
			if ($time_slot->id == $time_slot_id) {
				return $time_slot_key;
			}
		}
		return -1;
    }

	public function check_attendance_classroom_group( $selected_group_id = 0, $teacher_code = null , $selected_study_module_id = 0, 
		$lesson_id = 0, $day = 0, $month = 0, $year = 0, $selected_time_slot_id = 0 ) {

		$this->check_logged_user();	
		$active_menu = array();
		$active_menu['menu']='#check_attendance';
		$header_data = $this->load_header_data_11($active_menu);
        $this->_load_html_header($header_data);

		$userid=$this->session->userdata('id');
		$person_id=$this->session->userdata('person_id');
		
		//Check if user is a teacher
		$user_is_a_teacher = $this->attendance_model->is_user_a_teacher($person_id);

		$data['is_teacher'] = $user_is_a_teacher;
		
		/*******************
		/*      BODY       *
		/*******************/
		$this->_load_body_header($data);

		$user_is_admin = $this->ebre_escool->user_is_admin();

		if ( !($user_is_a_teacher || $user_is_admin) ) {
			//TODO: Return not allowed page!
			echo "Access Not Allowed!";
			return false;
		}		

		$user_teacher_code = $this->attendance_model->get_teacher_code_by_personid($person_id);

		if ($teacher_code == null) {
	    	$teacher_code = $user_teacher_code;
	    } else {
	    	if (!$user_is_admin) { 
	    		$teacher_code = $user_teacher_code; 
	    	}
	    }

	    //Teacher info to view
	    $data['teacher_code']= $teacher_code;

	    $teacher_info = $this->attendance_model->get_teacher_info_from_teacher_code($teacher_code);  

	    $teacher_department_id = 2;

		$teacher_id = $teacher_info['teacher_id'];  
		$teacher_givenName = $teacher_info['givenName'];
		$teacher_sn1 = $teacher_info['sn1'];
		$teacher_sn2 = $teacher_info['sn2'];

		//Teacher info to view
	    $data['teacher_code']= $teacher_code;   
	    $data['teacher_id']= $teacher_id;
	    $data['teacher_givenName']= $teacher_givenName;
	    $data['teacher_sn1']= $teacher_sn1;
	    $data['teacher_sn2']= $teacher_sn2;

	    //echo "teacher_id: $teacher_id<br/>";       
	    //echo "teacher_code: $teacher_code<br/>";   

	    //Departaments
	    $data['departments'] = array();
	    $department_info = $this->attendance_model->get_teacher_departmentInfo($teacher_id);
	    $data['selected_department_key'] = $department_info['id'];
	    $data['selected_department_name'] = $department_info['name'];
		if ($user_is_admin) {
	    	//Get all classroom_groups
	    	$data['departments']= $this->attendance_model->get_all_departments();
	    } else {
	    	$data['departments']= $this->attendance_model->get_teacher_departments($teacher_id);
	    }
        
	    //Obtain class_room_groups
	    $data['classroom_groups']=array();

	    if ($user_is_admin) {
	    	//Get all classroom_groups
	    	$data['classroom_groups']= $this->attendance_model->get_all_groupscodenameByDeparment($teacher_department_id);
	    } else {
	    	//IF TEACHER
	    	if($user_is_a_teacher) {
	    		$data['classroom_groups']=$this->attendance_model->get_all_groupscodenameByTeacher($teacher_id);
	    	}
	    }

	    if ($day == 0 ) {
	    	//obtain day from current date
			$day = date("d");
	    }
	    if ($month == 0 ) {
	    	//obtain month from current date
			$month = date("m");
	    }

	    if ($year == 0 ) {
	    	//obtain year from current date
			$year = date("y");
			$year_alt = date("Y");
	    } else {
	    	$year_alt = $year;
	    }

	    //isodate format: YYYY-MM-DD
		$iso_date = null;
		$data['check_attendance_date'] = "";
		$data['check_attendance_date_alt'] = "";

	    if ( ($day != null) && ($month != null) && ($year != null) ) {
	    	$data['check_attendance_date'] = $day . "/" . $month . "/" .$year;
	    	$data['check_attendance_date_alt'] = $day . "/" . $month . "/" .$year_alt;
	    	$iso_date = $year . "-" .  sprintf('%02s', $month) . "-" . sprintf('%02s', $day);
	    	$iso_date_alt = $year_alt . "-" .  sprintf('%02s', $month) . "-" . sprintf('%02s', $day);
	    } else {
	    	$data['check_attendance_date'] = date('d/m/Y');	
	    	$data['check_attendance_date_alt'] = $day . "/" . $month . "/" .$year_alt;
	    	$iso_date_alt = $year_alt . "-" .  sprintf('%02s', $month) . "-" . sprintf('%02s', $day);
	    }

		$data['check_attendance_date_mysql_format'] = $iso_date_alt;
	    
	    $day_of_week_number = date('N', strtotime($iso_date));

		$days_of_week = array();
		$timestamp = strtotime('next Monday');
		for ($i = 1; $i < 8; $i++) {
 			$days_of_week[$i] = strftime('%A', $timestamp);
 			$timestamp = strtotime('+1 day', $timestamp);
		}

		$data['days_of_week'] = $days_of_week;

		$data['day_of_week_number'] = $day_of_week_number;
		$data['day'] = $day;
		$data['month'] = $month;
		$data['year'] = $year;

		if ($selected_group_id == 0) {
			$selected_group_id = 25; //2ASIX	
		}	else {
			//Check if teacher could use this group. Necessary?
			//TODO
		}

	    $data['selected_classroom_group_key']=$selected_group_id;
	    
	    $data['all_lessons'] =array();

	    $all_lessons = $this->attendance_model->getAllLessonsByDay($day_of_week_number,$data['selected_classroom_group_key']);
	    $data['all_lessons'] = $all_lessons;


	    //OBTAIN ABSOLUTELY ALL STUDENTS:
	    $all_students_in_group = $this->attendance_model->getAllGroupStudentsInfoIncludedStudySubmodules($selected_group_id,$teacher_id,$day_of_week_number);

	    //echo "<br/>all_students_in_group count: " . count($all_students_in_group);
	    //GET ARRAYS OF STUDENTS BY FILTER --> ALLOW FILTER STUDENTS LIST

	    // OFFICIAL GROUP STUDENTS: STUDENTS ENROLLED TO GROUP:
	    $official_students_in_group = $this->attendance_model->getAllGroupStudentsInfo($selected_group_id);
	    
	    //$official_students_in_group = $this->attendance_model->getAllGroupStudentsIds($selected_group_id);
	    
	    $data['official_students_in_group'] = $official_students_in_group;
	    $data['official_students_in_group_num'] = count($official_students_in_group);

	    $selected_group_info = $this->attendance_model->getGroupInfoByGroupId($selected_group_id);

		$selected_group_id = $selected_group_info['id'];
		$selected_group_name = $selected_group_info['name'];
		$selected_group_shortname = $selected_group_info['shortname'];
		$selected_group_code = $selected_group_info['code'];

		$data['selected_group_id'] = $selected_group_id;
		$data['selected_classroom_group_code'] = $selected_group_code;
	    $data['selected_classroom_group_shortname'] = $selected_group_code;
		$data['selected_classroom_group'] = $selected_group_name;

		/* DEBUG:
		echo "selected_group_name: $selected_group_name<br/>";
		echo "selected_group_shortname: $selected_group_shortname<br/>";
		echo "selected_group_code: $selected_group_code<br/>";*/

		if ($selected_study_module_id == 0) {
			//TODO: Get default study_module_id
			$selected_study_module_id = 274;	
		}	else {
			//Check if teacher could use this study_module0
			//TODO
			//Be careful with tutors that can user all study modules of mentored groups!
		}

		$data['selected_study_module_key']= $selected_study_module_id;

        //echo "selected_study_module_id: " . $selected_study_module_id;
		$selected_study_module_info = $this->attendance_model->getStudyModuleInfoByModuleId($selected_study_module_id);

        //echo "selected_study_module_info: ";
        //print_r($selected_study_module_info);
        $selected_study_module_name = "";
        $selected_study_module_shortname = "";
        $selected_study_module_code = ""; 
        $data['selected_study_module_error']= false;
        $data['selected_study_module_error_message']= "";
        if (count($selected_study_module_info) > 0) {
            $selected_study_module_name = $selected_study_module_info['name'];
            $selected_study_module_shortname = $selected_study_module_info['shortname'];
            $selected_study_module_code = $selected_study_module_info['code'];
        } else {
            $data['selected_study_module_error']= true;
            $data['selected_study_module_error_message']="No s'ha trobat a la base de dades el mòdul professional/Crèdit: " . $selected_study_module_id . " contacteu amb l'administrador.";
        }
		
		/*
		echo "selected_study_module_name: $selected_study_module_name<br/>";
		echo "selected_study_module_shortname: $selected_study_module_shortname<br/>";
		echo "selected_study_module_code: $selected_study_module_code<br/>";*/

		$data['selected_study_module_code'] = $selected_study_module_code;
	    $data['selected_study_module_shortname'] = $selected_study_module_shortname;
		$data['selected_study_module'] = $selected_study_module_name;


	    $data['study_modules'] = array();
	    
	    $all_group_study_modules = $this->attendance_model->getAllGroupStudymodules( $selected_group_id);
	    $data['study_modules'] = $all_group_study_modules;

	    $data['time_slots'] = array();

	    $time_slots = $this->attendance_model->getTimeSlotsByClassgroupId($selected_group_id,$day_of_week_number);

	    $data['selected_lesson_id'] = $lesson_id;
	    
	    if ($selected_time_slot_id == 0) {
	    	if ($lesson_id != 0) {
		    	$selected_time_slot_id = $this->attendance_model->getTimeSlotKeyFromLessonId($lesson_id);
		    }	
	    }

	    if (array_key_exists($selected_time_slot_id, $time_slots)) {
	    	$data['selected_time_slot_id'] = $selected_time_slot_id;
	    	$data['selected_time_slot'] = $time_slots[$selected_time_slot_id]->range;
	    } else {
	    	if ($lesson_id != 0) {
	    		$selected_time_slot_id = $this->attendance_model->getTimeSlotKeyFromLessonId($lesson_id);
		    	$data['selected_time_slot_id'] = $selected_time_slot_id;
		    	$data['selected_time_slot'] = $time_slots[$selected_time_slot_id]->range;	
	    	} else {
	    		$data['selected_time_slot_id'] = null;
		    	$data['selected_time_slot'] = null;	
	    	}
	    	
	    }

		if (is_array($time_slots)) {
	    	$data['time_slots'] = $time_slots;
	    }

	    $group_teachers_array = $this->attendance_model->getAllTeachersFromClassgroupId( $selected_group_id );
	    $data['group_teachers']= $group_teachers_array;

	    //Tutor is default selected_group_teacher 	    
	    $tutor_teacher_id = $this->attendance_model->getTutorFromClassgroupId( $selected_group_id );

	    //echo "tutor_teacher_id: $tutor_teacher_id<br/>";

	    if ($tutor_teacher_id != "") {
	    	if (array_key_exists($tutor_teacher_id,$group_teachers_array)) {
	    		$selected_group_teacher = $group_teachers_array[$tutor_teacher_id]->sn1 . " " . $group_teachers_array[$tutor_teacher_id]->sn2 . ", " . 	
	    			$group_teachers_array[$tutor_teacher_id]->givenName . "( Tutor/a )";
	    	} else {
	    		$selected_group_teacher = "Error. No s'ha trobat el codi $tutor_teacher_id";
	    	}
	    		
	    } else {
	    	$selected_group_teacher = "Error. No hi ha tutor del grup";
	    }
	    

	    $data['selected_group_teacher']= $selected_group_teacher;
	    
	    $data['group_teachers_default_teacher_key']= $tutor_teacher_id;
	    if ($tutor_teacher_id == $teacher_id) {
	    	$data['teacher_is_mentor'] = true;
	    } else {
	    	$data['teacher_is_mentor'] = false;
	    }
	    	    
		//TODO: select current user (sessions user as default teacher)
	    $data['default_teacher'] = $teacher_code;

	    $data['total_number_of_students'] = count($all_students_in_group);

	    //echo "<br/> total_number_of_students : " . $data['total_number_of_students'] . "<br/>";

		$data['classroom_group_students'] = array ();
		$base_photo_url = "uploads/person_photos";
		
		/*
		print_r($all_students_in_group);
		echo "*********************";
		*/

		$number_of_enrolled_study_submodules = array ();

        $all_merged_students = array();
        if ( is_array ( $all_students_in_group ) && is_array ( $official_students_in_group )) {
            $all_merged_students = array_merge ($all_students_in_group,$official_students_in_group);
        } else if (is_array ($official_students_in_group)) {
            $all_merged_students = $official_students_in_group;
        } else if (is_array ($all_students_in_group)) {
            $all_merged_students = $all_students_in_group;
        }

		$number_of_enrolled_study_submodules = $this->attendance_model->get_number_of_enrolled_study_submodules( $all_merged_students);

		//print_r($number_of_enrolled_study_submodules);
		$data['number_of_enrolled_study_submodules'] = $number_of_enrolled_study_submodules;

		//Look for inconsistent/ error estudents
		$data['students_with_errors'] = array();
		$data['students_with_errors_num'] = 0;
		if (count($all_students_in_group) > 0) {
			$students_with_errors = array();
			foreach ($official_students_in_group as $official_student_key => $official_student) {
                if (is_array($all_students_in_group)) {
                    if ( ! array_key_exists($official_student_key, $all_students_in_group) ) {
                        if ($number_of_enrolled_study_submodules[$official_student->enrollment_id] == 0 ) { 
                            $official_student->errorType = "L'alumne no té cap UF/UD matrículada";
                        } else {
                            $official_student->errorType = "Matrícula incoherent. Alumne matrículat al grup però sense CAP Unitat Formativa DEL GRUP matrículada";  
                        }
                        $students_with_errors[$official_student_key]= $official_student;
                    }    
                }			
			}
			
            if (is_array($all_students_in_group)) {
    			foreach ($all_students_in_group as $student_key => $student) {
    				if ($number_of_enrolled_study_submodules[$student->enrollment_id] == 0 ) {
    					$student->errorType = "L'alumne no té cap UF/UD matrículada";
    					$students_with_errors[$student_key]= $student;
    				}
    			}
            }

			$data['students_with_errors'] = $students_with_errors;
			$data['students_with_errors_num'] = count($students_with_errors);
		}
		
		$hidden_students_in_group= array();
		$array_student_person_ids = array ();
		if ( $data['total_number_of_students'] != 0 ) {
			if ( is_array($all_students_in_group) && ( count($all_students_in_group) > 0  ) ) {
				foreach($all_students_in_group as $student)	{

					$array_student_person_ids[] = $student->person_id;

					if ($student->photo_url != "") {
						$path = "/usr/share/ebre-escool/uploads/person_photos/" . $student->photo_url;
						if (file_exists ($path)) {
							$student->photo_url = $base_photo_url."/".$student->photo_url;	
						} else {
							$student->photo_url = '/assets/img/alumnes/foto.png';
						}	
					}	else {
						$student->photo_url = '/assets/img/alumnes/foto.png';				
					}

					if ( array_key_exists($student->person_id, $official_students_in_group) ) {
						$student->official = true;
					} else {
						$student->official = false;
					}

					if ($student->hidden) {
						$hidden_students_in_group[] = $student;
					}
					

					$data['classroom_group_students'][]=$student;
				}	
			}
				
		}

	    //$hidden_students_in_group= $this->attendance_model->getAllGroupHiddenStudentsInfo($selected_group_id,teacher_id);
	    $data['hidden_students_in_group'] = $hidden_students_in_group;
	    $data['hidden_students_in_group_num'] = count($hidden_students_in_group);

		$incidents = $this->attendance_model->getAllIncidentsByDateAndPersonIdArray($array_student_person_ids,$iso_date_alt);

		$data['incidents'] = $incidents;

		$incident_types = $this->attendance_model->getAllIncident_types();

		$data['incident_types'] = $incident_types;

		$data['user_is_admin'] = $user_is_admin;

		$data['academic_period_id'] = $this->attendance_model->get_current_academic_period_id();
		
		$this->load->view('attendance/check_attendance_classroom_group',$data);
		 
		/*******************
		/*      FOOTER     *
		*******************/
		$this->_load_body_footer();	
	}


	public function check_attendance(
		$teacher_code = null, $day = null, $month = null, $year = null ,$url_group_code = null) {
 
 		$this->check_logged_user();

		$active_menu = array();
		$active_menu['menu']='#check_attendance';
		
		$header_data = $this->load_header_data($active_menu);
        $this->_load_html_header($header_data);

		/***************************
		/*      BODY               *
		/***************************/

		$data=array();

		$userid=$this->session->userdata('id');
		$person_id=$this->session->userdata('person_id');
		
		//Check if user is a teacher
		$user_is_a_teacher = $this->attendance_model->is_user_a_teacher($person_id);

		$data['is_teacher']=$user_is_a_teacher;
		$this->_load_body_header($data);

		$user_teacher_code = $this->attendance_model->get_teacher_code_by_personid($person_id);
		
		//TODO:
		$user_is_admin = $this->ebre_escool->user_is_admin();

		if (!$user_is_admin) {
			if ( !$user_is_a_teacher  ) {
				//TODO: Return not allowed page!
				return null;
			}		
		}			

		if ($teacher_code == null) {
	    	$teacher_code = $user_teacher_code;
	    } else {
	    	if (!$user_is_admin) { 
	    		$teacher_code = $user_teacher_code; 
	    	}
	    }

	    $teacher_info = $this->attendance_model->get_teacher_info_from_teacher_code($teacher_code);   

	    $teacher_id = $teacher_info['teacher_id'];
	    $teacher_full_name = $teacher_info['givenName'] . " " . $teacher_info['sn1'] . " " . $teacher_info['sn2'];

	    //echo "teacher_id: $teacher_id<br/>";       
	    //echo "teacher_code: $teacher_code<br/>";       
        
		if ($user_is_admin) {
			//Load teachers from Model
			$teachers_array = $this->attendance_model->get_all_teachers_ids_and_names();

			$data['teachers'] = $teachers_array;
		} else {
			//Show Only one teacher
			$teachers_array = $this->attendance_model->get_teacher_ids_and_names($teacher_id);
			$data['teachers'] = $teachers_array;
		}

	    $data['default_teacher'] = $teacher_code;

		$data['check_attendance_date'] = null;

		//isodate format: YYYY-MM-DD
		$iso_date = null;

	    if ( ($day != null) && ($month != null) && ($year != null) ) {
	    	$data['check_attendance_date'] = $day . "/" . $month . "/" .$year;
	    	$iso_date = $year . "-" .  sprintf('%02s', $month) . "-" . sprintf('%02s', $day);
	    } else {
	    	$data['check_attendance_date'] = date('d/m/Y');	
	    	$iso_date = $year . "-" .  sprintf('%02s', $month) . "-" . sprintf('%02s', $day);
	    }

	    $day_of_week_number = date('N', strtotime($iso_date));

		$data['day_of_week_number'] = $day_of_week_number;
	    $timestamp = strtotime('next Monday');
		$days_of_week = array();
		for ($i = 1; $i < 8; $i++) {
 			$days_of_week[$i] = strftime('%A', $timestamp);
 			$timestamp = strtotime('+1 day', $timestamp);
		}

		$data['days_of_week'] = $days_of_week;

		$data['teacher_code'] = $teacher_code;
		$data['teacher_full_name'] = $teacher_full_name;
		$data['day'] = $day;
		$data['month'] = $month;
		$data['year'] = $year;

		//Obtain Time Slots
		$all_lessons_by_teacherid_and_day = null;
		$all_lessons_by_teacherid_and_day = $this->attendance_model->get_all_lessons_by_teacherid_and_day($teacher_id,$day_of_week_number);
    	$time_slots_array = $this->attendance_model->get_all_time_slots_with_all_lessons_by_teacherid_and_day($all_lessons_by_teacherid_and_day);
    	
    	//echo "Number of lessons: " . count($all_lessons_by_teacherid_and_day) . "<br/>";

	    $data['time_slots_array'] = $time_slots_array;
	    $data['all_lessons_by_teacherid_and_day'] = $all_lessons_by_teacherid_and_day;

	    //print_r($time_slots_array);

	    $teacher_groups_current_day=array();
	    
	    $all_time_slots=array();
	    $all_time_slots_reduced=array();

	    $classroom_groups_colours = $this->_alt_assign_colours($all_lessons_by_teacherid_and_day,"classroom_group_code");
		$study_modules_colours = $this->_assign_colours($all_lessons_by_teacherid_and_day,"study_module_id");

	    foreach ($time_slots_array as $time_slot)	{
	    	$group_id = 0;
	    	$group_code = "";
			$base_url =  "";
			$group_shortname =  "";
			$group_name =  "";
			
			$lesson_code =  "";
			$lesson_shortname =  "";
			$lesson_name =  "";

			$lesson_location =  "";
			$lesson_location_id =  0;
   			$time_slot_data = new stdClass;
			$time_slot_data->time_interval= $time_slot->time_slot_start_time . " - " . $time_slot->time_slot_end_time;
			$time_slot_data->time_slot_lective = $time_slot->time_slot_lective;
			$time_slot_id = $time_slot->time_slot_id;
			$lesson_id = $time_slot->lesson_id;

			$time_slot_data->group_id = $time_slot->group_id;
			$time_slot_data->group_code = $time_slot->group_code;
			$time_slot_data->group_shortname = $time_slot->group_shortname;
			$time_slot_data->group_name = $time_slot->group_name;
			
			$time_slot_data->study_module_id = $time_slot->study_module_id;

			$time_slot_data->lesson_id = $time_slot->lesson_id;
			$time_slot_data->lesson_location = $time_slot->lesson_location;


			$time_slot_data->lesson_location_id = $time_slot->lesson_location_id;
			
			$time_slot_data->lesson_code = $time_slot->lesson_code;
			$time_slot_data->lesson_shortname = $time_slot->lesson_shortname;
			$time_slot_data->lesson_name = $time_slot->lesson_name;
			
			$time_slot_data->classroom_group_colour = "btn-default";
			if ( $time_slot->group_code != "" ) {
				if (array_key_exists($time_slot->group_code, $classroom_groups_colours)) {
					$time_slot_data->classroom_group_colour = $classroom_groups_colours[$time_slot->group_code];
				} 
			}
			$time_slot_data->lesson_colour = "btn-default";
			if ( $time_slot->study_module_id != "" ) {
				if (array_key_exists($time_slot->study_module_id, $study_modules_colours)) {
					$time_slot_data->lesson_colour = $study_modules_colours[$time_slot->study_module_id];
				} 
			}

   			$all_time_slots[] = $time_slot_data;
		}

		if (is_array($all_lessons_by_teacherid_and_day)) {
			foreach ($all_lessons_by_teacherid_and_day as $time_slot)	{
			
				$group_id = 0;
				$group_code = "";
				$base_url =  "";
				$group_shortname =  "";
				$group_name =  "";
				
				$lesson_id = 0;
				$lesson_code =  "";
				$lesson_shortname =  "";
				$lesson_name =  "";


				$lesson_location =  "";
	   			$time_slot_data = new stdClass;
				$time_slot_data->time_interval = $time_slot->time_slot_start_time . " - " . $time_slot->time_slot_end_time;
				$time_slot_data->time_slot_lective = $time_slot->time_slot_lective;
				$time_slot_id = $time_slot->time_slot_id;
				$lesson_id = $time_slot->lesson_id;

				//Obtain lesson for this teacher date and time slot
				$study_module_id = null;
				
				if (array_key_exists($lesson_id, $all_lessons_by_teacherid_and_day)) {
					$group_id = $all_lessons_by_teacherid_and_day[$lesson_id]->group_id;
					$group_code = $all_lessons_by_teacherid_and_day[$lesson_id]->group_code;
					$group_shortname = $all_lessons_by_teacherid_and_day[$lesson_id]->group_shortname;
					$group_name = $all_lessons_by_teacherid_and_day[$lesson_id]->group_name;
					$study_module_id = $all_lessons_by_teacherid_and_day[$lesson_id]->study_module_id;
					$lesson_code = $all_lessons_by_teacherid_and_day[$lesson_id]->lesson_code;
					$lesson_shortname = $all_lessons_by_teacherid_and_day[$lesson_id]->lesson_shortname;
					$lesson_name = $all_lessons_by_teacherid_and_day[$lesson_id]->lesson_name;
					$lesson_location = $all_lessons_by_teacherid_and_day[$lesson_id]->lesson_location;
					$lesson_location_id = $all_lessons_by_teacherid_and_day[$lesson_id]->lesson_location_id;
				}

				$time_slot_data->group_id = $group_id;
				$time_slot_data->group_code = $group_code;
				$time_slot_data->group_url= $base_url;
				$time_slot_data->group_shortname = $group_shortname;
				$time_slot_data->group_name = $group_name;

				$time_slot_data->study_module_id = $study_module_id;

				$time_slot_data->lesson_id = $lesson_id;
				$time_slot_data->lesson_code = $lesson_code;
				$time_slot_data->lesson_shortname = $lesson_shortname;
				$time_slot_data->lesson_name = $lesson_name;
				$time_slot_data->lesson_location = $lesson_location;
				$time_slot_data->lesson_location_id = $lesson_location_id;
				//Fallback color!
				$time_slot_data->classroom_group_colour = "btn-default";
				if ( $group_code != null ) {
					if (array_key_exists($group_code, $classroom_groups_colours)) {
						$time_slot_data->classroom_group_colour = $classroom_groups_colours[$group_code];
					} 
				}
				$time_slot_data->lesson_colour = "btn-default";
				if ( $study_module_id != null ) {
					if (array_key_exists($study_module_id, $study_modules_colours)) {
						$time_slot_data->lesson_colour = $study_modules_colours[$study_module_id];
					}
				}

	   			$all_time_slots_reduced[$lesson_id] = $time_slot_data;
			}	
		}
		
		
		$data['all_time_slots']=$all_time_slots;
		$data['all_time_slots_reduced']=$all_time_slots_reduced;

		//echo "Number of time_slots: " . count($all_time_slots_reduced) . "<br/>";

		/*foreach ($all_time_slots_reduced as $key => $time_slot) {
			echo "key: " . $key . " <br/>";
			echo "all_time_slots_reduced: " . var_export($all_time_slots_reduced) . " <br/><br/><br/>";
		}*/


		
		
		//Obtain all teacher groups for selected date		

		if(isset($group_code)){
			$data['$group_code'] = $group_code;	
		}	

		$data['check_attendance_day']="TODO";
		$data['check_attendance_table_title']=lang('check_attendance_table_title');
		$data['choose_date_string']=lang('choose_date_string');
		$data['today']=date('d-m-Y');

		$teacher_groups_current_day=array();
		
		/* Llista alumnes grup */

        $default_group_code = $group_code;
        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $header_data['header_title']=lang("all_students") . ". " . $organization;

        //Load CSS & JS
        //$this->set_header_data();
        $all_groups = $this->attendance_model->get_all_classroom_groups();

        $data['group_code']=$group_code;

        $data['all_groups']=$all_groups->result();

        $data['all_groups']=$all_groups->result();
        $data['photo'] = false;
        if ($group_code) {
            $data['selected_group']= urldecode($group_code);
                $data['photo'] = true;
        }   else {
            $data['selected_group']=$default_group_code;
        }
		/* fi llista alumnes grup */
		$this->load->view('attendance/check_attendance',$data);
		 
		/*******************
		/*      FOOTER     *
		*******************/
		$this->_load_body_footer();		
	}

	protected function _alt_assign_colours($items,$item_id) {
        $items_colours = array();
        $bootstrap_button_colours = 
            array( 1 => "btn-greenyellow " ,
                   2 => "btn-darkred",
                   3 => "btn-coral",
                   4 => "btn-olivedrab",
                   5 => "btn-yellowgreen",
                   6 => "btn-mignightblue",
                   7 => "btn-chocolate",
                   8 => "btn-crimson",
                   9 => "btn-default",
                   0 => "btn-darkslategray"
                   );
        $index=1;
        if ( is_array ( $items )) {
        	foreach ($items as $item) {
            	$items_colours[$item->$item_id] = $bootstrap_button_colours[$index];
            	$index++;
        	}
        }
            
        return $items_colours;
    }

	protected function _assign_colours($items,$item_id) {
        $items_colours = array();
        $bootstrap_button_colours = 
            array( 1 => "btn-primary" ,
                   2 => "btn-info"    ,
                   3 => "btn-warning" ,
                   4 => "btn-success" ,
                   5 => "btn-danger"  ,
                   6 => "btn-sadlebrown" ,
                   7 => "btn-purple" ,
                   8 => "btn-gold" ,
                   9 => "btn-palegreen" ,
                   10 => "btn-lightgray" ,
                   11 => "btn-greenyellow" ,
                   12 => "btn-chocolate",
                   13 => "btn-coral",
                   14 => "btn-olivedrab",
                   15 => "btn-yellowgreen",
                   16 => "btn-mignightblue",
                   17 => "btn-darkred",
                   18 => "btn-crimson",
                   19 => "btn-default",
                   20 => "btn-darkslategray"
                   );
        $index=1;
        if ( is_array ( $items )) {
        	foreach ($items as $item) {
            	$items_colours[$item->$item_id] = $bootstrap_button_colours[$index];
            	$index++;
        	}
        }
            
        return $items_colours;
    }

	public function index() {
		$this->check_attendance();
	}

    public function load_datatables_data() {

        //CSS
        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery-ui.css'));  
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));  
        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");                     
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js")); 
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url("assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"));   
        
        $this->_load_html_header($header_data);
        //$this->_load_html_header($header_data); 
        
        $this->_load_body_header();     

    }	
	
//OSCAR: GET TIME SLOTS
    public function get_time_slots($classroom_group_id=null,$lective)
    {
            $complete_time_slots_array = $this->attendance_model->getAllTimeSlots()->result_array();
            $data['complete_time_slots_count'] = count($complete_time_slots_array);            
            if($classroom_group_id){
                $shift = $this->attendance_model->get_group_shift($classroom_group_id);
			    $all_teacher_groups_time_slots[$classroom_group_id] = $this->attendance_model->get_time_slots_byShift($shift)->result_array();

                $time_slots_array = $this->attendance_model->get_time_slots_byShift($shift)->result_array();
            } else {
                $time_slots_array = $complete_time_slots_array;
            }

            $data['time_slots_array'] = $time_slots_array;

            //Get first and last time slot order
            $keys = array_keys($time_slots_array);
            $first_time_slot_order = $time_slots_array[$keys[0]]['time_slot_order'];
            $data['first_time_slot_order'] = $first_time_slot_order;            
            $last_time_slot_order = $time_slots_array[$keys[count($time_slots_array)-1]]['time_slot_order'];
            $data['last_time_slot_order'] = $last_time_slot_order;

            foreach ($time_slots_array as $time_slot)   {
                $time_slot_data = new stdClass;
                $time_slot_data->time_slot_start_time = $time_slot['time_slot_start_time'];
                $time_slot_data->time_interval = $time_slot['time_slot_start_time'] . " - " . $time_slot['time_slot_end_time'];
                $time_slot_data->time_slot_lective = $time_slot['time_slot_lective'];

                $time_slots[$time_slot['time_slot_id']] = $time_slot_data;
            }
            $time_slots_lective = array();
            $data['time_slots'] = $time_slots;
            foreach($time_slots as $time_slot){
            	if($time_slot->time_slot_lective == $lective){
            		$time_slots_lective[] = $time_slot;
            	}
            }
            $data['time_slots_lective'] = $time_slots_lective;
            $data['time_slots_count'] = count($time_slots);

            return $data;
    }    



public function hide_unhide_student_on_classroom_group_and_day() {

		/*
		  person_id : person_id,
	      classroom_group_id : classroom_group_id,
	      teacher_id : teacher_id,
	      academic_period_id : academic_period_id,
	      action : action,
	      day : day,
		*/

        $result = new stdClass();
        $result->result = false;
        $result->message = "No enough values especified!";

		$error = false;
		$person_id = "";
	    if(isset($_POST['person_id'])) {
        	$person_id = $_POST['person_id'];
	    } else {
	    	$error = true;
	    }

	    $classroom_group_id = "";
	    if(isset($_POST['classroom_group_id'])) {
        	$classroom_group_id = $_POST['classroom_group_id'];
	    } else {
	    	$error = true;
	    }

	    $teacher_id = "";
	    if(isset($_POST['teacher_id'])) {
        	$teacher_id = $_POST['teacher_id'];
	    } else {
	    	$error = true;
	    }

	    $academic_period_id = "";
	    if(isset($_POST['academic_period_id'])) {
        	$academic_period_id = $_POST['academic_period_id'];
	    } else {
	    	$error = true;
	    }

	    $action = "";
	    if(isset($_POST['action'])) {
        	$action = $_POST['action'];
	    } else {
	    	$error = true;
	    }

	    $day = "";
	    if(isset($_POST['day'])) {
        	$day = $_POST['day'];
	    } else {
	    	$error = true;
	    }

	    if (!$error) {
	    	if ($action =="hide") {
	    		$result = $this->attendance_model->hide_student_on_classroom_group_and_day($person_id, $classroom_group_id, $teacher_id, $academic_period_id, $day);
	    	} elseif ($action == "unhide") {
	    		$result = $this->attendance_model->unhide_student_on_classroom_group_and_day($person_id, $classroom_group_id, $teacher_id, $academic_period_id, $day);
	    	} else {
	    		$result->result = false;
        		$result->message = "No valid action specified!";
	    	}
	    		
	    }

	    print_r(json_encode($result));
}



public function add_callback_last_update(){  
   
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
}

public function add_field_callback_entryDate(){  
      $data= date('d/m/Y H:i:s', time());
      return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
}

public function edit_field_callback_entryDate($value, $primary_key){  
    //$this->session->flashdata('table_name');
      return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
    }
    
public function edit_callback_last_update($value, $primary_key){ 
    //$this->session->flashdata('table_name'); 
     return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', time()) .'"  name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
    }   

//UPDATE AUTOMATIC FIELDS BEFORE INSERT
function before_insert_object_callback($post_array, $primary_key) {
        //UPDATE LAST UPDATE FIELD
        $data= date('d/m/Y H:i:s', time());
        $post_array['entryDate'] = $data;
        
        $post_array['creationUserId'] = $this->session->userdata('user_id');
        return $post_array;
}

//UPDATE AUTOMATIC FIELDS BEFORE UPDATE
function before_update_object_callback($post_array, $primary_key) {
        //UPDATE LAST UPDATE FIELD
        $data= date('d/m/Y H:i:s', time());
        $post_array['last_update'] = $data;
        
        $post_array['lastupdateUserId'] = $this->session->userdata('user_id');
        return $post_array;
}

function load_ace_files($active_menu){

		$header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");

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
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/test_incidents_managment_by_ajax_css.css'));     
/*
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));  
*/
        
        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/jquery-1.9.1.js");
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/ui/1.10.3/jquery-ui.js");   

        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace.min.js'));    
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));

        $header_data['menu']= $active_menu;
        return $header_data;
}

function check_logged_user()
{
    if (!$this->skeleton_auth->logged_in())
    {
        //redirect them to the login page
        redirect($this->skeleton_auth->login_page, 'refresh');
    }

    //CHECK IF USER IS READONLY --> unset add, edit & delete actions
    $readonly_group = $this->config->item('readonly_group');
    if ($this->skeleton_auth->in_group($readonly_group)) {
        $this->grocery_crud->unset_add();
        $this->grocery_crud->unset_edit();
        $this->grocery_crud->unset_delete();
    }
}

function renderitzar($table_name,$header_data = null)
{
       $output = $this->grocery_crud->render();

       // HTML HEADER
        $this->_load_html_header($header_data,$output); 
        $this->_load_body_header();      
       
       // BODY       
       $default_values=$this->_get_default_values();
       $default_values["table_name"]=$table_name;
       $default_values["field_prefix"]=$table_name."_";
       $this->load->view('defaultvalues_view.php',$default_values); 

       $this->load->view($table_name.'.php',$output);     
       
       // FOOTER     
       $this->_load_body_footer();  

}

function common_callbacks()
{
        //CALLBACKS        
        $this->grocery_crud->callback_add_field($this->session->flashdata('table_name').'_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_last_update',array($this,'edit_callback_last_update'));
}

function userCreation_userModification($table_name)
{   
    //USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
    $this->grocery_crud->set_relation($table_name.'_creationUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($table_name,$table_name.'_creationUserId',$this->session->userdata('user_id'));

    //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
    $this->grocery_crud->set_relation($table_name.'_lastupdateUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($table_name,$table_name.'_lastupdateUserId',$this->session->userdata('user_id'));
}

function set_common_columns_name($table_name){
    $this->grocery_crud->display_as($table_name.'_entryDate',lang('entryDate'));
    $this->grocery_crud->display_as($table_name.'_last_update',lang('last_update'));
    $this->grocery_crud->display_as($table_name.'_creationUserId',lang('creationUserId'));                  
    $this->grocery_crud->display_as($table_name.'_lastupdateUserId',lang('lastupdateUserId'));   
    $this->grocery_crud->display_as($table_name.'_markedForDeletion',lang('markedForDeletion'));       
    $this->grocery_crud->display_as($table_name.'_markedForDeletionDate',lang('markedForDeletionDate')); 
}

}
