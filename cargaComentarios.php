<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
	
	/**
	* Se encarga de obtener el avatar de los demas
	* @param Usuario $user USuario del que queremos obtener su avatar
	* @return string $htmlAvatar HTML relativo al avatar del amigo
	*/
   function generaAvatarVisitante($user){
	   $srcAvatar = $user->getAvatar();

	   $htmlAvatar = '';
	   $htmlAvatar .= '<img class = "right" src = "';
	   $htmlAvatar .= $srcAvatar;
	   $htmlAvatar .= '">';
	   return $htmlAvatar;
	}
	function generaBotones($idCom, $autor, $idForo){
		$botones = '';
		if(isset($_SESSION['login'])){
			if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 4 || $_SESSION['ID'] == $autor){
				$formDelForo = new FormularioEliminarCom($idCom,$autor, $idForo);
				$htmlDelForo = $formDelForo->gestiona();
				$botones .= <<<EOS
				<div class="col-1 botonesNoticiaConcreta">
					<div class="botonIndividualNoticia">
						<a href="editarComentario.php?id=$idCom" class="btn btn-link"><img class="botonModificarNoticia" src="img/pencil.svg"/></a>
					</div>
					<div class="botonIndividualNoticia">
						$htmlDelForo
					</div>
				</div>
				EOS;
			}
		}
		return $botones;
	}
	/**
	 * Genera el historial de comentarios de un foro
	 * @param Usuario $usuario Usuario que ha iniciado sesion
	 * @return string $htmlMensaje Todo el historico de mensajes en HTML
	 */
	function generaCom($comentarios, $idForo){
		$htmlComentarios = '';
		if($comentarios != null){
			$redireccion = 'foro_particular.php?id=' . $idForo;
			foreach ($comentarios as $comentario){
				$formUpvote = new FormularioUpvoteCom($comentario->getId(),$_SESSION['ID'], $redireccion);
				$formHTMLUpVote = $formUpvote->gestiona();
				$formDownvote = new FormularioDownvoteCom($comentario->getId(),$_SESSION['ID'], $redireccion);
				$formHTMLDownVote = $formDownvote->gestiona();
				$botones = generaBotones($comentario->getId(), $comentario->getAutor(), $idForo);
				$contenido = $comentario->getContenido();
				$fecha = $comentario->getFecha();
				$autor = Usuario::buscaPorId($comentario->getAutor());
				$nombreAutor = $autor->getUsername();
				$upvotes = $comentario->getUpvotes();
				$downvotes = $comentario->getDownvotes();

				if($comentario->getAutor() == $_SESSION['ID']){
					$avatar = generaAvatarVisitante($autor);
					
					$htmlComentarios.=<<<EOF
						<div class="mensaje row">
							<div class="col-4">
								<div class="row">
									<div class="col-2">
										$formHTMLUpVote
										$formHTMLDownVote
									</div>
									<div class="col-1">
										<p class = "autorForo">$upvotes</p>
										<p class = "fechaForo">$downvotes</p>
									</div>
								</div>
							</div>
							<div class='textoCom col'>
								<p class = "usuarioMensajes"> $contenido </p>
							</div>
							<div class='comExtra col'>
								$avatar
								<p class = "NombreUsuario text-end"> $nombreAutor </p>
								<span class="time-right"> $fecha </span>
							</div>
							$botones
						</div>
					EOF;
				}

				else{
					$avatar = generaAvatarVisitante($autor);
					$nombreAutor = $autor->getUsername();
					$htmlComentarios.=<<<EOF
						<div class="mensaje darker row">
							<div class="col-4">
								<div class="row">
									<div class="col-2">
										$formHTMLUpVote
										$formHTMLDownVote
									</div>
									<div class="col-1">
										<p class = "autorForo">$upvotes</p>
										<p class = "fechaForo">$downvotes</p>
									</div>
								</div>
							</div>
							<div class='textoCom col'>
								<p class = "usuarioMensajes"> $contenido </p>
							</div>
							<div class='comExtra col'>
								$avatar
								<p class = "NombreUsuario text-end"><a class="text-decoration-none" href="perfilExt.php?id=$nombreAutor"> $nombreAutor </a></p>
								<span class="time-right"> $fecha </span>
							</div>
							$botones
						</div>
					EOF;
				}
			}  
		}
		else{
			$htmlComentarios = "No hay ningún comentario en este foro";
		}      
		return $htmlComentarios;
	}
	
	
	$foroID = $_GET['id'];
	$foro = Foro::buscaForo($foroID);
	if($foro != false){
		$comentarios = Comentario::getComentarios($foro->getId());
		echo generaCom($comentarios, $foro->getId());
	}
?>