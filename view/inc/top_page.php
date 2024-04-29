<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <title>Alta de Vivienda</title>


<!-- BOOTSTRAP CORE STYLE CSS -->
<link href="view/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLE CSS -->
    <link href="view/assets/css/font-awesome.min.css" rel="stylesheet" />
    <!-- CUSTOM STYLE CSS -->
    <link href="view/assets/css/style.css" rel="stylesheet" />    
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" />
    	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
		
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    	<script type="text/javascript">
        	$(function() {
        		$('#uploaddate').datepicker({
        			dateFormat: 'dd/mm/yy', 
        			changeMonth: true, 
        			changeYear: true, 
        			yearRange: '1900:2024',
        			onSelect: function(selectedDate) {
        			}
        		});
        	});
	    </script>
	
	    <script src="module/Home/model/validate_vivienda.js"></script>
		<script src="module/search/model/ctrl_search.js"></script>
		<script  src = "view/js/promises.js"></script>
		<script  src = "view/js/activity_user.js"></script>
		<script  src = "view/glider/glider.js"></script>
		<link rel="stylesheet" type="text/css" href="view/glider/glider.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

		<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
		
<script src='https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.css' rel='stylesheet' />
		
		
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    
    </head>
    <body>









