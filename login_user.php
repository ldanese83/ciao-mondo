<?@include("share/header2.0.php");
	
	$user = $_POST["user_login"];
	$pass = $_POST["pass_login"];
	
	$dataset = eseguiQuery("select count(*) as tot from utenti_pizza where login='$user' and password='$pass'");
	$row=mysql_fetch_array($dataset);
	if($row["tot"]==0) {
	
		$dataset = eseguiQuery("select count(*) as tot from utenti_pizza where login='$user'");
		$row=mysql_fetch_array($dataset);
		if($row["tot"]==0)  {
		?>
			<div id="content">

				<div class="alert alert-danger my_error" role="alert">
				<p><strong>Errore!</strong> Lo username inserito non è corretto. Prego riprovi ad inserire i suoi dati.</p>
				</div> 
				<div class="recupero">
				<form class="form-signin" role="Login" action="login_user.php" method="POST" style="margin-left:-20px;">
					<div class="form-group">
					  <input type="text" class="form-control" placeholder="Username" name="user_login" />
					  <input type="password" class="form-control" placeholder="Password" name="pass_login" />
					</div>
					<button type="submit" class="btn btn-primary" style="margin-top:10px;">Login</button>
				</form>
				<p style="margin-left:-20px;padding:0px;color:black;">Hai perso i tuoi dati? Inserisci la mail con la quale ti eri iscritto e provvederemo ad inviarti nuovamente i dati di iscrizione</p>
				<form class="form-signin" role="Login" action="recupero_dati.php?perso=entrambi" method="POST" style="margin-left:-20px;">
					<div class="form-group">
					  <input type="text" class="form-control" placeholder="Mail" name="mail_recupero" required />
					</div>
					<button type="submit" class="btn btn-primary" style="margin-top:10px;">Invia</button>
				</form>
				</div>
			</div><!-- /.content -->
		<?
		} else {
		?>
		<div id="content">

			<div class="alert alert-danger my_error" role="alert">
			<p><strong>Errore!</strong> La password inserita non è corretta. Prego riprovi ad inserire i suoi dati.</p>
			</div> 
			<div class="recupero">
			<form class="form-signin" role="Login" action="login_user.php" method="POST" style="margin-left:-20px;">
				<div class="form-group">
				  <input type="text" class="form-control" placeholder="Username" name="user_login" value="<?echo $user;?>" />
				  <input type="password" class="form-control" placeholder="Password" name="pass_login" />
				</div>
				<button type="submit" class="btn btn-primary" style="margin-top:10px;">Login</button>
			</form>
			<p style="margin-left:-20px;padding:0px;color:black;">Hai perso la password? Inserisci la mail con la quale ti eri iscritto e provvederemo ad inviarti la tua password</p>
			<form class="form-signin" role="Login" action="recupero_dati.php?perso=pass" method="POST" style="margin-left:-20px;">
				<div class="form-group">
				  <input type="text" class="form-control" placeholder="Mail" name="mail_recupero" required />
				</div>
				<button type="submit" class="btn btn-primary" style="margin-top:10px;">Invia</button>
			</form>
			</div>
		</div><!-- /.content -->
		
		
		<?
		}
	}else {
		//login effettuato
		$cookie_name = "user";
		$cookie_value = $user;
		setcookie($cookie_name, $cookie_value, time() + (86400 * 2), "/");
		header('Location: index.php');
	}
		
?>
		
<?@include("share/footer.php");?>
		