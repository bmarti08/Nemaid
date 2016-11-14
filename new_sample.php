			<?php 
			include('includes/haut.php');
			include("connectionSQL.php");
			//connexion_bdd();
			?>
				<?php
			 if($_POST['genus']=='heli1' or $_POST['genus']=='heli2' or $_POST['genus']=='heli3'){
			$nom_genus='heli1';
			
			}
			else if($_POST['genus']=='apha') 
			{
			$nom_genus='apha';
			}
			if($nom_genus!=NULL){
			$_SESSION['genus_n']=$nom_genus;
			} 
			if($_SESSION['genus_n']!=NULL){
			$genus_name = define_genus();
			}
			if(isset($_SESSION['my_file'])){
			$valeur=$_SESSION['my_file'];
			$user_sample = get_xml_data('user_sample',$valeur);
			}
			?>
			<script type="text/javascript">
				function allto1($type) {
					var inputs = document.getElementsByTagName('input');
					for(var i=0; i<inputs.length; i++) {
						if(inputs[i].className == $type) { inputs[i].value = 1; }
					}
				}

				
				function getXMLHttpRequest() {
					var xhr = null;
					if (window.XMLHttpRequest || window.ActiveXObject) {
						if (window.ActiveXObject) {
							try  {
								xhr = new ActiveXObject("Msxm12.XMLHTTP");
							} catch(e) {
								xhr = new ActiveXObject("Microsoft.XMLHTTP");
							}
						} else {
							xhr = new XMLHttpRequest();
						}
					} else {
						alert("Votre navigateur ne supporte pas l'objet XMLHttpRequest...");
						return null;
					}
					return xhr;
				}
				
				var xhr = getXMLHttpRequest();
				xhr.open("GET", "default_params.xml", false);
				xhr.send(null);
				var xmldoc = xhr.responseXML;
				
				function default_values($type) {
					if ('<?php echo $genus_name ?>' == 'Helicotylenchus' ) {
						var values = xmldoc.getElementsByTagName('genus')[1].getElementsByTagName('char');
					} else {
						var values = xmldoc.getElementsByTagName('genus')[0].getElementsByTagName('char');
					}

					var res = new Array();

					for (var i=0; i<values.length; i++) {
						var length = values[i].childNodes.length;
						var input_name = values[i].getAttribute('name');
						switch ($type) {
							case 'qt_weight': 
								if (length > 0) {
									res[i] = values[i].childNodes[1].firstChild.nodeValue;
									input_name = values[i].getAttribute("name").concat('_w');
								} break;
							case 'qt_correction': 
								if (length > 3) {
									res[i] = values[i].childNodes[3].firstChild.nodeValue;
									input_name = values[i].getAttribute("name").concat('_c');
								} break;
							case 'qt_rangeValue': 
								if (length > 3) {
									res[i] = values[i].childNodes[5].firstChild.nodeValue;
									input_name = values[i].getAttribute("name").concat('_r');
								} break;
							case 'ql_weight': 
								if (length == 3) {
									res[i] = values[i].childNodes[1].firstChild.nodeValue;
									input_name = values[i].getAttribute("name").concat('_w');
								} break;
						}
						
						var inputs = document.getElementsByTagName('input');
						for(var j=0; j<inputs.length; j++) {
							if (inputs[j].name == input_name) { 
							inputs[j].value = res[i]; }				
						}
					}
				}
				
				function verif_champs() {
					var inputs = document.getElementsByTagName('input');

					for(var i=0; i<inputs.length; i++) {
						if(inputs[i].type == 'text' && inputs[i].value == '') {
							alert("Error: All fields must be filled."); 
							return false;
						}
					}
					
					return true;
				}
				
				
			</script>
			<div id="new_sample">
				<ul>
				<li><h3>Upload a previously saved sample file: </h3></li>
					 
					
						<form method="POST" action="ftp.php" enctype="multipart/form-data">
		 <!-- On limite le fichier ? 100Ko -->
		 <input type="hidden" name="MAX_FILE_SIZE" value="100000">
		 Fichier : <input type="file" name="avatar">
		 <input type="hidden" name="genus_name" value=<?php echo"$genus_name"; ?> />
		 <input type="submit" name="envoyer" value="Envoyer le fichier">
	</form>
								
					This file must be a .xml file generated by Nemaid 3.3.
				<br /><br />
				
				<li><h3>Or register a new sample now :</h3></li>
				<form name="new_sample" action="save.php" method="post">

					<table>
						<tr><h3><br />Sample information</h3></tr>

							<tr>
								<td>Sample number</td>
								<td><input type="text" name="sample_id"></td>
							</tr>
							<tr>
								<td>Date of sampling</td>
								<td><input type="date" name="sample_date"></td>
							</tr>
							<tr>
								<td>Remarks</td>
								<td><textarea rows="3" name="remarks"></textarea></td>
							</tr>
						
						</table>
						<table border="1">
						<tr><h3>Quantitative characters</h3></tr>
						<tr>Enter your sample data in the column "Values". Weights and correction factors are used for the
						computation of the similarity coefficient. You can change the default values at will or set all 
						weights and/or correction factors if you prefer to use non weighted data.</tr>
						<tr>
							<th >Characters</th>
							<th>Explanations</th>
							<th>Values</th>				
							<th>Weights</th>
							<th>Correction factors</th>
						</tr>
						<?php
						
							$query1 = mysqli_query($con,"select id_character from MIN_MAX natural join GENUS where name_genus ='$genus_name'");
							while ($row = mysqli_fetch_array($query1)){
								$idCharacter=$row['id_character'];
								$query2 = mysqli_query($con,"select entitled_character, explaination,weight, correction_factor 
							from CHARACTER1 natural join IS_COMPOUND_BY natural join ANALYSIS 
							where quantitative=true and id_character='$idCharacter' group by name_character");
								
							
							
							/* while($row = mysqli_fetch_row($query)){
							$code_char=$row[0];
							if(isset($valeur)){
							$val=$user_sample[$code_char]['value'];
							/* if($user_sample!=NULL){
							$val=$user_sample[$code_char]['value']; */
							//}
							//else{
							//$val='';
							//} 
								/* if($use_user_params) {
									$weight = $user_params[(string)$row["code_char"]]['weight'];
									$correction = $user_params[(string)$row["code_char"]]['correction'];
									$explanations = $user_params[(string)$row["code_char"]]['explanations'];
									$rangeValue = $ç[(string)$row["code_char"]]['rangeValue'];
								} else {
									$weight = sprintf('%.2f',round($row["weight"],2));
									$correction = sprintf('%.2f',round($row["correction"],2));
									$rangeValue = sprintf('%.2f',round($row["rangeValue"],2));
									$explanations = $user_params[(string)$row["code_char"]]['explanations'];
								} */
								while ($row2 = mysqli_fetch_array($query2))
			{
									$weight=$row2['weight'];
									$correction=$row2['correction_factor'];

									
									echo "<tr>";

				echo "<td><b>" .$row2['entitled_character'] . "</b></td>";
				echo "<td>" .$row2['explaination'] . "</td>";
				echo '<td>' . '<INPUT TYPE="text" name="ValueSet'.$idCharacter.'"  value="NULL">'  . '</td>';
				echo '<td>' . '<INPUT class="qt_weight" TYPE="text" name="WeightSet'.$idCharacter.'"  value="'.$weight.'">'  . '</td>';
				echo '<td>' . '<INPUT class="qt_correction" TYPE="text" name="WeightSet'.$idCharacter.'" value="'.$correction.'">'  . '</td>';

				
				
				echo "</tr>";
								}
							}
						?>
						
							<tr>
							<th></th>
							<th></th>
							<th></th>
							<td>
								<input type="button" value="Set all to 1" onclick="allto1('qt_weight')">
								<br/>
								<input type="button" value="Defaults values" onclick="default_values('qt_weight')">
							</td>
							<td>
								<input type="button" value="Defaults values" onclick="default_values('qt_correction')">
							</td>
							<!--<td>
								<input type="button" value="Calculate range" onclick="default_values('qt_rangeValue')">
							</td> -->
						</tr>
						</table>
						<table border="1">

						<tr><h3><br />Qualitative characters</h3>
						</tr>
						<tr>For each qualitative character, enter each state separately as the percentage of specimens 
						presenting that state.
						Percentages must be entered as decimal values, not as percents (e.g. enter 0.57 instead of 57%).</tr>
						<tr>
							<th>Characters </th>
							<th>Explanations</th>
							<th>Values</th>				
							<th>Weights</th>
							<th>Correction factors</th>
						</tr>
						<?php
							
								$query1 = mysqli_query($con,"select id_character from MIN_MAX natural join GENUS where name_genus ='$genus_name'");
							while ($row = mysqli_fetch_array($query1)){
								$idCharacter=$row['id_character'];
								$query2 = mysqli_query($con,"select entitled_character, explaination,weight, correction_factor 
							from CHARACTER1 natural join IS_COMPOUND_BY natural join ANALYSIS 
							where quantitative=false and id_character='$idCharacter' group by name_character");
							
							
							
							
							/* while($row = mysqli_fetch_row($query)){
							$code_char=$row[0];
							if(isset($valeur)){
							$val=$user_sample[$code_char]['value'];
							/* if($user_sample!=NULL){
							$val=$user_sample[$code_char]['value']; */
							//}
							//else{
							//$val='';
							//} 
								/* if($use_user_params) {
									$weight = $user_params[(string)$row["code_char"]]['weight'];
									$correction = $user_params[(string)$row["code_char"]]['correction'];
									$explanations = $user_params[(string)$row["code_char"]]['explanations'];
									$rangeValue = $ç[(string)$row["code_char"]]['rangeValue'];
								} else {
									$weight = sprintf('%.2f',round($row["weight"],2));
									$correction = sprintf('%.2f',round($row["correction"],2));
									$rangeValue = sprintf('%.2f',round($row["rangeValue"],2));
									$explanations = $user_params[(string)$row["code_char"]]['explanations'];
								} */
								while ($row2 = mysqli_fetch_array($query2))
			{
									$weight=$row2['weight'];
									$correction=$row2['correction_factor'];

									
									echo "<tr>";

				echo "<td><b>" .$row2['entitled_character'] . "</b></td>";
				echo "<td>" .$row2['explaination'] . "</td>";
				echo '<td>' . '<INPUT TYPE="text" name="Value2Set'.$idCharacter.'" required pattern="0\.\d{2}|NULL"  title="example 0.53 = 53%" value="NULL">'  . '</td>';
				echo '<td>' . '<INPUT TYPE="text" name="Weight2Set'.$idCharacter.'" value="'.$weight.'">'  . '</td>';
				echo '<td>' . '<INPUT TYPE="text" name="Weight2Set'.$idCharacter.'"" value="'.$correction.'">'  . '</td>';
				
				
				echo "</tr>";
								
							}
							}
							?>
							
						
					</table>
					<br/><br/>
					<input type="hidden" name="file_type" value="sample">
					<input type="submit" value="Save sample" > 
				</form>
				</ul>
			</div>

			<?php
			//mysqli_close($con);
			?>