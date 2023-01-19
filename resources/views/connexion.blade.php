<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		<title>LiveTogether - Se connecter</title>
	</head>
	<body>
		<div class="login-box"> 
			<h2 style="color: #F1DCC9">Connexion</h2>
			<form>
				<div class="user-box">
					<input type="text" name="" required=""> <label>Nom d'utilisateur</label>
				</div> 
				<div class="user-box">
					<input type="password" name="" required="">
					<label>Mot de passe</label>
				</div>
				<!-- <div>
					<input type="checkbox" id="remember" name="remember" checked>
					<label for="scales">Se souvenir de moi</label>
				</div> -->
				<a href="#">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					Se connecter
				</a>
			</form>
		</div>
	</body>
</html>