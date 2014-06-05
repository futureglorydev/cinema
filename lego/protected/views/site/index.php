<?php
	#header('Content-Type: text/html; charset=UTF-8');
?><html>
	<head>
		<title>Test API</title>
		<style type="text/css">
			body div{width:600px;margin:4px auto;border:1px dashed #999999;padding:10px;font-size:12px;}
			form p label{display:block;font-size:11px;font-weight:bold;}
			form p input{border:1px solid #c0c0c0;width:100%;margin-bottom:4px;padding:4px 6px;font-size:14px;}
			body iframe{width:600px;height:200px;margin:0 auto;border:1px dashed #999999;}
		</style>
		<script type="text/javascript"  src="/js/jquery.js" ></script>
	</head>
	<body>
		<div>
			<form name="api" action="/api" method="get">
				<p>
					<label>Метод</label>
					<input type="text" name="method" id="method" value="get" />
				</p>
				<p>
					<label>Экшн</label>
					<input type="text" name="action" id="action" value="cinema" />
				</p>
				<p>
					<label>Строка запроса</label>
					<input type="text" name="query" id="query" value="title=mega" />
				</p>
				<p id="submit-p">
					<input type="submit" value="Create form" id="submit"/>
				</p>
			</form>
		</div>
		<center>
			<div id="response"></div>
		</center>
		<center>
			<div id="tip">
				<p>
					<br>
					Нужно пользователю дать возможность просмотреть расписание кинотеатра, с возможностью фильтрации по залу.
					Без парметров - список кинотеатров: <br>

					<b>GET /api/cinema/?[title=название кинотеатра][hall=название зала]</b><br>

					Также надо дать возможность просмотреть в каких кинотеатрах/залах идёт конкретный фильм:<br>

					<b>GET /api/movie?title=название фильма</b><br>

					Затем надо проверить, какие места свободны на конкретный сеанс:<br>

						<b>GET /api/seance/?places=true&id=id сеанса</b><br>

					И дать возможность купить билет:<br>

							<b>POST /api/ticket?action=buy&seance=id сеанса&places=1,3,5,7</b><br>

					Результатом запроса должен быть уникальный код, характеризующий этот набор билетов<br>

					И отменить покупку, но не ПОЗЖЕ, чем за час до начала сеанса:<br>

								<b>POST /api/ticket/?action=cancel&hash=уникальный код покупки</b><br><br>
				</p>
			</div>
		</center>
		<script type="text/javascript">
			jQuery(function(){


				jQuery('#submit').click(function(event){
					event.preventDefault();

					var data = {
						method: document.getElementById("method").value,
						action: document.getElementById("action").value,
						query:  document.getElementById("query").value
					};
console.log(data);
					$.ajax({
						type: data.method,
						url: "/api/"+data.action,
						data: data.query,
						success: function (response) {
							$('#response').html(response);
						}
					});


				});

			});
		</script>
	</body>
</html>