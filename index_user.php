<?@include("share/header_pren2.0.php");?>
		
	<script src="js/vedi_prenotazione_user.js"></script>

	<div id="content">
		<div id="content_prenotazioni">   

          <h1>Ultime prenotazioni effettuate/da ritirare</h1>
			
			<div id="vedi_prenotazione" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Visualizza prenotazione</h4>
				  </div>
				  <div class="modal-body">
					<div id="vedi_modale">
						
					</div>
					<div class="alert alert-success" role="alert" id="termina_pizza">Pizze eliminate!</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
		  </div>
			
			<table class="tabella_prenotazioni">
			
				<tr class="header_tabelle">
				
					<th>Data</th>
					<th>Orario</th>
					<th>Numero Prenotazione</th>
					<th>Consegna a Domicilio</th>
					<th>Stato</th>
					<th></th>
				
				</tr>
				
				<?
				
					$query = "select * from prenotazioni,utenti_pizza
					where fk_utente=id_utente and login='$utente_loggato'
					and confermata=1
					and collegamento_pren = 0
					order by giorno desc, id_prenotazione desc
					limit 0,20";
					
					$dataset = eseguiQuery($query);
					
					$data_odierna = date("Y-m-d");
					$ore = date("H");
					
					$counter=0;
					$classe = "riga0";
					$ritir = "Conclusa";
					$domicilio ="No";
					
					while ($row = mysql_fetch_array($dataset)) {
					
						if($counter%2==0) $classe = "riga0";
						else $classe = "riga1";
						
						if($row["giorno"]==$data_odierna && $ore <$row["ore"]) {
							$classe = "prenotazione_in_sospeso";
							$ritir = "Da consegnare";
						}
						
						if($row["consegna_domicilio"]==1) $domicilio="Si";		
						
						echo "<tr class='$classe'>";
						echo "<td>".date('d/m/Y',strtotime($row["giorno"]))."</td>";
						echo "<td>$row[ore]:".str_pad($row["minuti"],2,'0',STR_PAD_LEFT)."</td>";
						echo "<td>$row[id_prenotazione]</td>";
						echo "<td>$domicilio</td>";
						echo "<td>$ritir</td>";
						echo "<td style='text-align:center;'><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#vedi_prenotazione' onclick=aggiorna_vedi($row[id_prenotazione])>Visualizza</button>";
						echo "</tr>";
						
						$counter++;
						
						$ritir = "Conclusa";
						$domicilio ="No";
					}
				
				?>
			
			
			</table>
			
			<?
				if($counter==0) {
			?>
			<div class="alert alert-warning" style="margin-top:2em;" role="alert">
			<p><strong>Attenzione!</strong> Nessuna prenotazione è stata ancora effettuata</p>
			</div> 
			<?
				}
			?>
			
	</div></div>
<?@include("share/footer_pren2.0.php");?>
		