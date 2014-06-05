<!DOCTYPE html>

<html>
<head>
	<title>Страница не найдена</title>
	<base href="<?php echo Yii::app()->params['baseUrl'] ?>"/>

    <meta charset="utf-8">
     <meta name="keywords" content="">
    <meta name="description" content="" >
    <meta name="robots" content="index, follow">


    <!-- Links -->
    <link rel="stylesheet" type="text/css" media="screen, projection" href="/css/main.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

</head>
<body>
<div class="global">

	<!--~~~~~~~~~~~~~~~~~~~~~~~~~ Header ~~~~~~~~~~~~~~~~~~~~~~~~~-->
	<div class="header">
		<div class="header-inside">


		</div>
	</div>


    <!--~~~~~~~~~~~~~~~~~~~~~~~~~ Steps ~~~~~~~~~~~~~~~~~~~~~~~~~-->


    <!--~~~~~~~~~~~~~~~~~~~~~~~~~ Main ~~~~~~~~~~~~~~~~~~~~~~~~~-->

	<div class="invite-mess" style="min-height: 205px; padding-top: 100px; background: none;">
	    <div class="http_error-mess-title">
			<?php  echo ($data['message']? nl2br(CHtml::encode($data['message'])) : 'Страница не найдена'); ?>
			<br />
			<a href="<?php echo $_SERVER['HTTP_REFERER']?>" >вернуться назад</a> | <a href="/" >на главную</a>
		</div>
	</div>



	<div class="footer-clearing"></div>


</div> <!--/Div.Global-->

</body>
</html>