<html>
	<head>
		<style>
			<?php
			if( $_GET["font"] ) {
				echo '@import url(http://fonts.googleapis.com/css?family=' . str_replace(' ', '+', $_GET["font"]) . ':' . $_GET["wi"] . ');';
			}
			?>

			.preview_style {
				<?php echo $_GET["css"]; ?>
			}
		</style>
	</head>
	<body>
		<div class="preview_style">Grumpy wizards make toxic brew for the evil Queen and Jack. <br /> 0 1 2 3 4 5 6 7 8 9</div>
	</body>
</html>