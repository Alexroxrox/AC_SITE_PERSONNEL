<!DOCTYPE html>
<html>
	<head>
		<title>AC - site personnel</title>
		<meta charset="UTF-8"/>
		<link rel="icon" type="image/png" href="images/logo/logo_AC_red_2.png" />
		<link type="text/css" rel="stylesheet" href="css/general.css"/>
		<link type="text/css" rel="stylesheet" href="css/mes_competences.css"/>
		<link type="text/css" rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css"/>
		
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.12.1/jquery-ui.js"></script>
		
		<script type="text/javascript">
			function checkDate(field) {
				var minYear = 1902;
				var maxYear = (new Date()).getFullYear();

				var error = false;

				// Regex format date
				re = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;

				if(field.value != '') {
					if(regs = field.value.match(re)) {
						if(regs[1] < 1 || regs[1] > 31) {
							error = true;
						} else if(regs[2] < 1 || regs[2] > 12) {
							error = true;
						} else if(regs[3] < minYear || regs[3] > maxYear) {
							error = true;
						}
					} else {
						error = true;
					}
				}

				if(error == true) {
					return false;
				}
				return true;
			};
			function scroll_anim() {
				$(".scroll").animate({opacity: 0.2}, 1500);
				$(".scroll").animate({opacity: 1}, 1500, scroll_anim);
			};
			$(document).ready(function() {
				// Animation indication scroll
				scroll_anim();

				// Evenement scroll
				var delay = false;
				$(document).on('mousewheel DOMMouseScroll', function(event) {
					event.preventDefault();

					if(delay) return;

					delay = true;
					setTimeout(function(){delay = false},200)

					var wd = event.originalEvent.wheelDelta || -event.originalEvent.detail;

					var a= document.getElementsByTagName('section');
					if(wd < 0) {
						for(var i = 0 ; i < a.length ; i++) {
							var t = a[i].getClientRects()[0].top;
							if(t >= 40) break;
						}
					}
					else {
						for(var i = a.length-1 ; i >= 0 ; i--) {
							var t = a[i].getClientRects()[0].top;
							if(t < -20) break;
						}
					}

					if(i >= 0 && i < a.length) {
						$('html,body').animate({scrollTop: a[i].offsetTop}, 2000);
					}
				});

				/* Submit du form du module 1*/
				$("#mdl_1").on("submit", function(e) {
					e.preventDefault();
					var champ_date = checkDate(this.birth);
					if(champ_date!=true) {
						$("section#module_1 #result span").html("Une erreur est présente dans la date").css("color", "#A00404");
						$("section#module_1 form#mdl_1 #birth").val("").focus();
					} else {
						$.ajax({
							type: 'POST',
						    url: 'ajaxPhpScript/mdl_1_your_birthday.php',
						    data: $(this).serialize(),
						    success: function(response) {
						    	var resp = JSON.parse(response);
					    		var nom = $("#nom").val();
					    		var prenom = $("#prenom").val();
					    		var age = resp["age"];
					    		var jour_restant = resp["jour_rest"];

						    	if (jour_restant=="0") {
						    		var message = prenom+" "+nom+",<br> Votre anniversaire est aujourd'hui.<br> Vous avez "+age+" ans.";
						    	} else {
						    		var message = prenom+" "+nom+",<br> Votre anniversaire est dans "+jour_restant+" jours.<br> Vous aurez "+age+" ans.";
						    	}
					    		$("section#module_1 #result span").html(message).css("color", "black");
						    	$("section#module_1 #result").css("display", "inline-block");
						    }
						});
					}
				});
				/* Ouverture boite de dialogue - Technologies utilisée - Module 1*/
				$("section#module_1 #content_detail .tech#html").click(function() {
					$("#container_module_1, #dialBox_module_1").show();
					$("#dialBox_module_1 #title span:first").html("Code HTML");
					$("#dialBox_module_1").css("height", "398px").css("width", "985px");
					$("#dialBox_module_1 #content").css("height", "inherit");
					$("#dialBox_module_1 img").attr("src", "images/module_1/code_html.PNG").css("height", "360px");
				});
				$("section#module_1 #content_detail .tech#css").click(function() {
					$("#container_module_1, #dialBox_module_1").show();
					$("#dialBox_module_1 #title span:first").html("Code CSS");
					$("#dialBox_module_1").css("height", "398px").css("width", "363px");
					$("#dialBox_module_1 #content").css("height", "363px");
					$("#dialBox_module_1 img").attr("src", "images/module_1/code_css.PNG").css("height", "600px");
				});
				$("section#module_1 #content_detail .tech#js").click(function() {
					$("#container_module_1, #dialBox_module_1").show();
					$("#dialBox_module_1 #title span:first").html("Code JavaScript, jQuery et ajax");
					$("#dialBox_module_1").css("height", "396px").css("width", "981px");
					$("#dialBox_module_1 #content").css("height", "363px");
					$("#dialBox_module_1 img").attr("src", "images/module_1/code_js.PNG").css("height", "500px");
				});
				$("section#module_1 #content_detail .tech#php").click(function() {
					$("#container_module_1, #dialBox_module_1").show();
					$("#dialBox_module_1 #title span:first").html("Code PHP");
					$("#dialBox_module_1").css("height", "396px").css("width", "515px");
					$("#dialBox_module_1 #content").css("height", "363px");
					$("#dialBox_module_1 img").attr("src", "images/module_1/code_php.PNG").css("height", "500px");
				});
				$("#dialBox_module_1 #close").on("click", function() {
					$("#container_module_1, #dialBox_module_1").hide();
				});

				// Module 2 - Submit ajouter todo
				$("form#mdl_2_add").on("submit", function(e) {
					e.preventDefault();
					$.ajax({
						type: 'POST',
					    url: 'ajaxPhpScript/mdl_2_add_todo.php',
					    data: $(this).serialize(),
					    success: function(response) {
					    	var resp = JSON.parse(response);
					    	if (resp["reslt"] == "success") {
					    		var id = resp["ID"];
					    		var list = resp["liste"];
					    		/* Création de la ligne */
								var html_todo =	"<tr id='"+id+"'>";
								html_todo +=		"<td class='state'>";
								html_todo +=			"<img class='state' src='images/icones/check_0.png'>";
								html_todo +=		"</td>";
								html_todo +=		"<td class='lib'>";
								html_todo +=			"<span>"+list+"</span>";
								html_todo += 			"<input type='text' style='display: none;'/>";
								html_todo += 		"</td>";
								html_todo += 		"<td class='upd'>";
								html_todo += 			"<img class='upd' src='images/icones/rouage.png'/>";
								html_todo += 			"<span class='upd'= style='display: none;'>OK</span>";
								html_todo += 		"</td>";
								html_todo += 		"<td class='del'>";
								html_todo += 			"<span class='del'>X</span>";
								html_todo += 		"</td>";
								html_todo += 	"</tr>";
					    		// Ajouter à la suite du tbody:
								$("section#module_2 table tbody").append(html_todo);
								$("form#mdl_2_add #add").val("");

					    	}
					    }
					});
				});
				// Suprimer un todo
				$("#listTodo table").on("click","span.del",function() {
					var idTodo = $(this).parents('tr').attr('id');
					$.ajax({
						type: 'POST',
					    url: 'ajaxPhpScript/mdl_2_del_todo.php',
					    data: "idTodo=" + idTodo,
					    success: function(response) {
					    	if (response == "success") {
					    		$("#listTodo tr#"+idTodo).remove();
					    	};
					    }
					});
				});
				// Modifier un todo - affichage
				$("#listTodo table").on("click","img.upd",function() {
					var idTodo = $(this).parents('tr').attr('id');
					val_todo = $("#listTodo tr#"+idTodo+" span:first").html();
					$("#listTodo tr#"+idTodo+" td.lib span").hide();
					$("#listTodo tr#"+idTodo+" td.lib input").val(val_todo);
					$("#listTodo tr#"+idTodo+" td.lib input").show();
					$("#listTodo tr#"+idTodo+" td.upd img").hide();
					$("#listTodo tr#"+idTodo+" td.upd span.upd").show();
				});
				// Modifier un todo
				$("#listTodo table").on("click","span.upd",function() {
					var idTodo = $(this).parents('tr').attr('id');
					var lib_todo  =$("#listTodo tr#"+idTodo+" input:first").val();
					$.ajax({
						type: 'POST',
					    url: 'ajaxPhpScript/mdl_2_upd_todo.php',
					    data: "idTodo=" + idTodo+"&libTodo=" + lib_todo,
					    success: function(response) {
					    	var resp = JSON.parse(response);
					    	if (resp["reslt"] == "success") {
					    		var lib_todo = resp["lib_todo"];
					    		$("#listTodo tr#"+idTodo+" td.lib span").html(lib_todo).show();
					    		$("#listTodo tr#"+idTodo+" td.lib input").hide();
					    		$("#listTodo tr#"+idTodo+" td.upd img").show();
					    		$("#listTodo tr#"+idTodo+" td.upd span.upd").hide();
					    	} else if (resp["reslt"] == "noChange") {
					    		$("#listTodo tr#"+idTodo+" td.lib span").show();
					    		$("#listTodo tr#"+idTodo+" td.lib input").hide();
					    		$("#listTodo tr#"+idTodo+" td.upd img").show();
					    		$("#listTodo tr#"+idTodo+" td.upd span.upd").hide();
					    	}
					    }
					});
				});
				// Check un todo
				$("#listTodo table").on("click","img.state",function() {
					var idTodo = $(this).parents('tr').attr('id');
					$.ajax({
						type: 'POST',
					    url: 'ajaxPhpScript/mdl_2_chk_todo.php',
					    data: "idTodo=" + idTodo,
					    success: function(response) {
					    	var resp = JSON.parse(response);
					    	if (resp["reslt"] == "success") {
					    		var state_todo = resp["state_todo"];
					    		$("#listTodo tr#"+idTodo+" img.state").attr("src", "images/icones/check_"+state_todo+".png");
					    	}
					    }
					});
				});
				// Module 3 - Submit connexion
				$("form#mdl_3_connect").on("submit", function(e) {
					e.preventDefault();
					$.ajax({
						type: 'POST',
					    url: 'ajaxPhpScript/mdl_3_connect.php',
					    data: $(this).serialize(),
					    success: function(response) {
					    	var resp = JSON.parse(response);
					    	if (resp["reslt"] == "success") {
					    		var identifiant = resp["identifiant"];
					    		var type_compte = resp["type"];
					    		$("section#module_3 form#mdl_3_connect").hide();
								$("section#module_3 form#mdl_3_connect #identifiant").val("");
								$("section#module_3 form#mdl_3_connect #mdp").val("");

								$("section#module_3 #zone_connect #lib_connect").html(identifiant+" ["+type_compte+"]");
					    		$("section#module_3 #zone_connect").show();
					    		// Si l'utilisateur est un lecteur
					    		if (type_compte == "lecteur") {
									// Affichage des livres empruntés par l'utilisateur
									var emprunt_lecteur = resp["emprunt_lecteur"];
									var nb_emprunt = emprunt_lecteur.length;
									// Si l'utilisateur a emprunté des livres
									if (nb_emprunt != 0) {
										$("section#module_3 #zone_lecteur #message span").html("");
										$("section#module_3 #zone_lecteur table#livres_emprunt tbody").html("");
										$.each(emprunt_lecteur, function(key, value) {
											var livre = value[0];
											var html = "<tr><td>"+livre+"</td></tr>";
											$("section#module_3 #zone_lecteur table#livres_emprunt tbody").append(html);
										});
										$("section#module_3 #zone_lecteur table#livres_emprunt").show();
									} else {
										$("section#module_3 #zone_lecteur table#livres_emprunt").hide();
										// Affichage d'un message signalant que le lecteur n'a emprunté aucun livre
										$("section#module_3 #zone_lecteur #message span").html("Vous n'avez emprunté aucun livre.")
									}

									$("section#module_3 #zone_lecteur").show();
								// Si l'utilisateur est une bibliotécaire
					    		} else if(type_compte == "bibliothécaire") {
					    			var bibliotheque = resp["bibliotheque"];
					    			var emprunt = resp["emprunt"];
					    			var lecteur = resp["lecteur"];

					    			// Remplissage des menus déroullant "Ajouter un emprunt"
					    			//Menu déroulant "livre emprunté"
					    			$("section#module_3 #zone_bibliothecaire select#livre").html("<option value='' selected>// Livre //</option>");
					    			$.each(bibliotheque, function(key, value) {
										var livre = value[0];
										var id_livre = value[1];
										var html = "<option value='"+id_livre+"'>"+livre+"</option>";
										$("section#module_3 #zone_bibliothecaire select#livre").append(html);
									});
									//Menu déroulant "lecteur empruntant"
									$("section#module_3 #zone_bibliothecaire select#lecteur").html("<option value='' selected>// Lecteur //</option>");
					    			$.each(lecteur, function(key, value) {
										var lecteur = value[0];
										var id_lecteur = value[1];
										var html = "<option value='"+id_lecteur+"'>"+lecteur+"</option>";
										$("section#module_3 #zone_bibliothecaire select#lecteur").append(html);
									});
					    			// Affichage des livre encore disponible dans la bibliothèque (tableau)
					    			$("section#module_3 #zone_bibliothecaire table#bibliotheque tbody").html("");
					    			$.each(bibliotheque, function(key, value) {
										var livre = value[0];
										var id_livre = value[1];
										var html = "<tr id='"+id_livre+"'><td>"+livre+"</td><td class='del'><span class='del'>X</span></td></tr>";
										$("section#module_3 #zone_bibliothecaire table#bibliotheque tbody").append(html);
									});
					    			// Affichage des livres emprunté et leur emprunteur (tableau)
					    			$("section#module_3 #zone_bibliothecaire table#emprunt tbody").html("");
									$.each(emprunt, function(key, value) {
										var livre = value[0];
										var emprunteur = value[1];
										var id_livre = value[2];
										var html = "<tr id='"+id_livre+"'><td>"+livre+"</td><td>"+emprunteur+"</td><td class='rendre'><img class='rendre' src='images/icones/check_1.png'/></td></tr>";
										$("section#module_3 #zone_bibliothecaire table#emprunt tbody").append(html);
									});
					    			// Affichage des lecteurs (tableau)
					    			$("section#module_3 #zone_bibliothecaire table#lecteur tbody").html("");
									$.each(lecteur, function(key, value) {
										var lecteur = value[0];
										var id_lecteur = value[1];
										var html = "<tr id='"+id_lecteur+"'><td>"+lecteur+"</td><td class='del'><span class='del'>X</span></td></tr>";
										$("section#module_3 #zone_bibliothecaire table#lecteur tbody").append(html);
									});

					    			$("section#module_3 #zone_bibliothecaire").show();
					    		}
					    	}
					    }
					});
				});
				// Module 3 - Se déconnecter
				$("section#module_3").on("click","span#deconnect",function() {
					$("section#module_3 #zone_connect").hide();
					
					$("section#module_3 #zone_lecteur").hide();
					$("section#module_3 #zone_lecteur table#livres_emprunt tbody").html("");

					$("section#module_3 #zone_bibliothecaire").hide();
					$("section#module_3 #zone_bibliothecaire table#bibliotheque tbody").html("");
					$("section#module_3 #zone_bibliothecaire table#emprunt tbody").html("");
					$("section#module_3 #zone_bibliothecaire table#lecteur tbody").html("");
					
					$("section#module_3 form#mdl_3_connect").show();
				});
				// Ajouter un emprunt
				$("form#add_emprunt").on("submit", function(e) {
					e.preventDefault();
					$.ajax({
						type: 'POST',
					    url: 'ajaxPhpScript/mdl_3_add_emprunt.php',
					    data: $(this).serialize(),
					    success: function(response) {
					    	var resp = JSON.parse(response);
					    	if (resp["reslt"] == "success") {
					    		var id_livre = resp["id_livre"];
					    		var livre = resp["livre"];
					    		var lecteur = resp["lecteur"];

					    		// Ajout du nouvel emprunt dans la liste des emprunts
					    		var html = "<tr id='"+id_livre+"'><td>"+livre+"</td><td>"+lecteur+"</td><td class='rendre'><img class='rendre' src='images/icones/check_1.png'/></td></tr>";
					    		$("section#module_3 #zone_bibliothecaire table#emprunt tbody").append(html);
					    		// Suppression du livre dans la bibliothèque (livre restant)
					    		$("section#module_3 #zone_bibliothecaire table#bibliotheque tr#"+id_livre).remove();
					    		// Suppression du livre dans le menu déroulant des emprunt
					    		$("section#module_3 #zone_bibliothecaire select#livre option[value='"+id_livre+"']").remove();
					    	}
					    }
					});
				});
				// Rendre un livre
				$("section#module_3").on("click","img.rendre",function() {
					var id_livre = $(this).parents('tr').attr('id');
					$.ajax({
						type: 'POST',
					    url: 'ajaxPhpScript/mdl_3_rendre_emprunt.php',
					    data: 'id_livre='+id_livre,
					    success: function(response) {
					    	var resp = JSON.parse(response);
					    	if (resp["reslt"] == "success") {
					    		var id_livre = resp["id_livre"];
					    		var livre = resp["livre"];
					    		// Livre enlevé des emprunt
					    		$("section#module_3 #zone_bibliothecaire table#emprunt tr#"+id_livre).remove();
					    		// Livre remis dans la bibliothèque
					    		var html = "<tr id='"+id_livre+"'><td>"+livre+"</td><td class='del'><span class='del'>X</span></td></tr>";
								$("section#module_3 #zone_bibliothecaire table#bibliotheque tbody").append(html);
								// Livre proposé dans le menu déroulant des emprunt
								var html = "<option value='"+id_livre+"'>"+livre+"</option>";
								$("section#module_3 #zone_bibliothecaire select#livre").append(html);
					    	}
					    }
					});
				});
				// Ajouter un livre
				$("form#add_livre").on("submit", function(e) {
					e.preventDefault();
					$.ajax({
						type: 'POST',
					    url: 'ajaxPhpScript/mdl_3_add_livre.php',
					    data: $(this).serialize(),
					    success: function(response) {
					    	var resp = JSON.parse(response);
					    	if (resp["reslt"] == "success") {
					    		var id_livre = resp["id_livre"];
					    		var livre = resp["livre"];
					    		// Réinitialisation de l'input
					    		$("section#module_3 #zone_bibliothecaire form#add_livre input#livre").val("");
					    		// Ajout dans la bibliothèque
								var html = "<tr id='"+id_livre+"'><td>"+livre+"</td><td class='del'><span class='del'>X</span></td></tr>";
								$("section#module_3 #zone_bibliothecaire table#bibliotheque tbody").append(html);
					    		// Ajout dans le menu déroulant des livres empruntable
								var html = "<option value='"+id_livre+"'>"+livre+"</option>";
								$("section#module_3 #zone_bibliothecaire select#livre").append(html);
					    	}
					    }
					});
				});
				// Ajouter un lecteur
				$("form#add_lecteur").on("submit", function(e) {
					e.preventDefault();
					$.ajax({
						type: 'POST',
					    url: 'ajaxPhpScript/mdl_3_add_lecteur.php',
					    data: $(this).serialize(),
					    success: function(response) {
					    	var resp = JSON.parse(response);
					    	if (resp["reslt"] == "success") {
					    		var id_lecteur = resp["id_lecteur"];
								var lecteur = resp["lecteur"];
								// Réinitialisation des inputs
								$("section#module_3 #zone_bibliothecaire form#add_lecteur input#lecteur").val("");
								$("section#module_3 #zone_bibliothecaire form#add_lecteur input#mdp").val("");
								// Ajout dans la liste des lecteurs
								var html = "<tr id='"+id_lecteur+"'><td>"+lecteur+"</td><td class='del'><span class='del'>X</span></td></tr>";
								$("section#module_3 #zone_bibliothecaire table#lecteur tbody").append(html);
								// Ajout dans le menu déroulant choix de l'emprunteur
								var html = "<option value='"+id_lecteur+"'>"+lecteur+"</option>";
								$("section#module_3 #zone_bibliothecaire select#lecteur").append(html);
					    	} else if (resp["reslt"] == 'exist') {
								// Réinitialisation des inputs
								$("section#module_3 #zone_bibliothecaire form#add_lecteur input#lecteur").val("");
								$("section#module_3 #zone_bibliothecaire form#add_lecteur input#mdp").val("");
					    	}
					    }
					});
				});
				// Supprimer un livre
				$("section#module_3 table#bibliotheque").on("click","span.del",function() {
					var id_livre = $(this).parents('tr').attr('id');
					$.ajax({
						type: 'POST',
					    url: 'ajaxPhpScript/mdl_3_del_livre.php',
					    data: 'id_livre='+id_livre,
					    success: function(response) {
					    	if (response=="success") {
					    		// Suppression du livre dans la bibliothèque (livre restant)
					    		$("section#module_3 #zone_bibliothecaire table#bibliotheque tr#"+id_livre).remove();
					    		// Suppression du livre dans le menu déroulant des emprunts
					    		$("section#module_3 #zone_bibliothecaire select#livre option[value='"+id_livre+"']").remove();
					    	}
					    }
					});
				});
				// Supprimer un lecteur
				$("section#module_3 table#lecteur").on("click","span.del",function() {
					var id_lecteur = $(this).parents('tr').attr('id');
					$.ajax({
						type: 'POST',
					    url: 'ajaxPhpScript/mdl_3_del_lecteur.php',
					    data: 'id_lecteur='+id_lecteur,
					    success: function(response) {
					    	if(response=="emprunt") {
					    		$("section#module_3 #zone_bibliothecaire #zone_information span").html("Information : Le lecteur dispose de livres empruntés, vous ne pouvez pas le supprimer pour l'instant.")
					    		$("section#module_3 #zone_bibliothecaire #zone_information").css("display", "inline-block");
					    		$("section#module_3 #zone_bibliothecaire #zone_information").delay(6000).fadeOut("slow");
					    	} else if (response=="success") {
					    		// Suppression du lecteur dans la la liste des lecteur
					    		$("section#module_3 #zone_bibliothecaire table#lecteur tr#"+id_lecteur).remove();
					    		// Suppression du livre dans le menu déroulant des emprunts
					    		$("section#module_3 #zone_bibliothecaire select#lecteur option[value='"+id_lecteur+"']").remove();

					    	}
					    }
					});
				});
			});
		</script>
	</head>
	<body>
		<?php
		include 'includes/navBar.php';
		?>

		<section id="introduction">
			<div id="couche">
				<header id="banner">
					<div id="container">
						<img id="bannerLogo" src="images/logo/logo_AC_black_2.png"/>
						<h1>site personnel</h1>
					</div>
				</header>
				<div id="container">
					<h2>Mes compétences</h2>
					<div id="content">
						<span>
							Via divers modules développés par mes soins,
							<br>
							je vous présente mes capacités en développement web.
						</span>
					</div>
					<img src="images/photo/perso_1.png">
				</div>
				<div class="scrollBot scroll">
					<div id="container">
						<img src="images/icones/down-arrow_white.png">
						<span>Défilement</span>
					</div>
				</div>
			</div>
		</section>

		<section id="module_1">
			<div class="scrollTop scroll">
				<div id="container">
					<img src="images/icones/top-arrow_white.png">
					<span>Défilement</span>
				</div>
			</div>
			<div id="container_1">
				<div id="container_2">
					<h2>Module 1 : Votre anniversaire</h2>
					<div id="content">
						<div id="content_module">
							<form id="mdl_1">
								<div id="info">
									<label>Votre nom :</label>
									<input type="text" id="nom" name="nom" maxlength="20" required/>
									<br>
									<label>Votre prénom :</label>
									<input type="text" id="prenom" name="prenom" maxlength="20" required/>
									<br>
									<label>Date de naissance :</label>
									<input type="text" id="birth" name="birth" placeholder="jj/mm/aaaa" required pattern="\d{1,2}/\d{1,2}/\d{4}"/>
								</div>
								<div id="validation">
									<input type="submit" value="Valider">
								</div>
							</form>
							<div id="result">
								<span></span>
							</div>
						</div>
						<br>
					</div>
				</div>
			</div>
			<div id="content_detail">
				<span>
					<b>Technologies utilisées :</b>
					<img id="infoBulle" alt="" title="Cliquer sur les technologies pour voir le code associé." src="images/icones/info_bulle.png">
				</span><br>
				<span id="html"  class="tech">- HTML</span><br>
				<span id="css" class="tech">- CSS</span><br>
				<span id="js" class="tech">- JavaScript - jQuery - ajax</span><br>
				<span id="php" class="tech">- PHP</span>
			</div>
			<div class="scrollBot scroll">
				<div id="container">
					<img src="images/icones/down-arrow_white.png">
					<span>Défilement</span>
				</div>
			</div>
		</section>
		<!-- Boites de dialogue Module 1-->
		<div id="container_module_1">
			<div id="dialBox_module_1">
				<div id="title">
					<span></span>
					<span id="close">X</span>
				</div>
				<div id="content">
					<img src=""/>
				</div>
			</div>	
		</div>
		<!-- Fin - Boites de dialogue Module 1-->

		<?php
		// Connexion à la base de données
		include 'includes/connect.php';
		?>
		<section id="module_2">
			<div class="scrollTop scroll">
				<div id="container">
					<img src="images/icones/top-arrow_white.png">
					<span>Défilement</span>
				</div>
			</div>
			<div id="container_1">
				<div id="container_2">
					<h2>Module 2 : Todo list</h2>
					<div id="content">
						<div id="content_module">
							<form id="mdl_2_add">
								<div id="addTodo">
									<label>Ajouter :</label>
									<input type="text" id="add" name="add" required maxlength="40"/>
									<input type="submit" value="Ok">
								</div>
								<div id="info">
									<span></span>
								</div>
							</form>
							<div id="listTodo">
								<table>
									<thead>
										<tr>
											<th>Etat</th>
											<th>A faire</th>
											<th>Modifier</th>
											<th>Supprimer</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$req_todo = "SELECT * FROM todo_list;";
										$result_todo = $connection->query($req_todo);
										foreach ($result_todo as $key => $row) {
											?>
											<tr id="<?=$row['ID']?>">	
												<td class="state">
													<img class="state" src="images/icones/check_<?=$row['state']?>.png">
												</td>
												<td class="lib">
													<span><?= $row["list"]; ?></span>
													<input type="text" maxlength="40" style="display: none;"/>
												</td>
												<td class="upd">
													<img class="upd" src="images/icones/rouage.png"/>
													<span class="upd" style="display: none;">OK</span>
												</td>
												<td class="del">
													<span class="del">X</span>
												</td>
											</tr>
											<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="content_detail">
				<span>
					<b>Technologies utilisées :</b>
				</span>
				<br>
				<span id="html"  class="tech">- HTML</span>
				<br>
				<span id="css" class="tech">- CSS</span>
				<br>
				<span id="js" class="tech">- JavaScript - jQuery - ajax</span>
				<br>
				<span id="php" class="tech">- PHP</span>
				<br>
				<span id="sql" class="tech">- SQL - MySQL</span>
			</div>
			<div class="scrollBot scroll">
				<div id="container">
					<img src="images/icones/down-arrow_white.png">
					<span>Défilement</span>
				</div>
			</div>
		</section>

		<section id="module_3">
			<div class="scrollTop scroll">
				<div id="container">
					<img src="images/icones/top-arrow_white.png">
					<span>Défilement</span>
				</div>
			</div>
			<div id="container_1">
				<div id="container_2">
					<h2>Module 3 : La bibliothéque</h2>
					<div id="content">
						<div id="content_module">
							<form id="mdl_3_connect">
								<label>Identifiant :</label><input type='text' id='identifiant' name='identifiant' required/>
								<br>
								<label>Mot de passe :</label><input type='password' id='mdp' name='mdp' required/>
								<br>
								<input type='submit' value='Connexion'/>
							</form>
							<div id='zone_connect'>
								<span id='lib_connect'></span>
								<span id='deconnect'>Se déconnecter</span>
							</div>
							<div id='zone_bibliothecaire'>
								<div id='zone_form'>
									<form id='add_livre'>
										<label>Ajouter un livre :</label>
										<input id="livre" name="livre" type='text' maxlength="40" required/>
										<input type='submit' value='Ok'/>
									</form>
									<form id='add_lecteur'>
										<label>Ajouter un lecteur :</label>
										<input type='text' id='lecteur' name='lecteur' maxlength="20" required/>
										<label id="lbl_mdp">Mot de passe :</label>
										<input type='password' id='mdp' name='mdp' maxlength="20" required/>
										<input type='submit' value='Ok'/>
									</form>
									<form id='add_emprunt'>
										<label>Ajouter un emprunt :</label>
										<select id="livre" name="livre" required>
											<option value="" selected>// Livre //</option>
										</select>
										<select id="lecteur" name="lecteur" required>
											<option value="" selected>// Lecteur //</option>
										</select>
										<input type='submit' value='Ok'/>
									</form>
								</div>
								<br>
								<div id="zone_information">
									<span></span>
								</div>
								<div id="zone_table">
									<!-- Livre encore disponible dans la bibliothèque (non emprunté) -->
									<table id='bibliotheque'>
										<caption>Bibliotèque</caption>
										<thead>
											<tr>
												<th id="livres">Livres</th>
												<th>Supprimer</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									<!-- Livre empruntés et leur emprunteur -->
									<table id='emprunt'>
										<caption>Emprunt</caption>
										<thead>
											<tr>
												<th>Livres</th>
												<th>Lecteur</th>
												<th>Rendre</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									<!-- Liste des lecteurs -->
									<table id='lecteur'>
										<caption>Lecteur</caption>
										<thead>
											<tr>
												<th>Lecteur</th>
												<th>Supprimer</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>	
							<div id='zone_lecteur'>
								<div id="message">
									<span></span>
								</div>
								<table id='livres_emprunt'>
									<caption>Livres empruntés</caption>
									<thead>
										<tr>
											<th>Livres</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="content_info">
				<span><b>Compte bibliothécaire :</b></span>
				<br>
				<span>- Login : "admin" - Mot de passe : "admin"</span>
				<br>
				<span><b>Compte lecteur :</b></span>
				<br>
				<span>- Login : "demo" - Mot de passe : "demo"</span>
			</div>
			<div id="content_detail">
				<span>
					<b>Technologies utilisées :</b>
				</span>
				<br>
				<span id="html"  class="tech">- HTML</span>
				<br>
				<span id="css" class="tech">- CSS</span>
				<br>
				<span id="js" class="tech">- JavaScript - jQuery - ajax</span>
				<br>
				<span id="php" class="tech">- PHP</span>
				<br>
				<span id="sql" class="tech">- SQL - MySQL</span>
			</div>
			<footer>
				<?php
				include 'includes/footer.php';
				?>
			</footer>
		</section>
		<!-- Boites de dialogue Module 3 -->
		<div id="container_module_3">
			<div id="dialBox_module_3">
				<div id="title">
					<span>Information</span>
					<span id="close">X</span>
				</div>
				<div id="content">
					<span></span>
				</div>
			</div>	
		</div>
		<!-- Fin - Boites de dialogue Module 3 -->
	</body>
</html>