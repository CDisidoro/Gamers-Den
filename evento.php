<?php namespace es\fdi\ucm\aw\gamersDen;

// Procesamos la cabecera Content-Type
$contentType= $_SERVER['CONTENT_TYPE'] ?? 'application/json';
$contentType = strtolower(str_replace(' ', '', $contentType));

// Verificamos corresponde con uno de los tipos soportados
$acceptedContentTypes = array('application/json;charset=utf-8', 'application/json');
$found = false;
foreach ($acceptedContentTypes as $acceptedContentType) {
    if (substr($contentType, 0, strlen($acceptedContentType)) === $acceptedContentType) {
        $found=true;
        break;
    }
}

if (!$found) {
    http_response_code(400);
    echo 'Este servicio REST sólo soporta el content-type application/json';
    die();
}

$result = null;

/**
 * Las API REST usan la semántica de los métoods HTTP para gestionar las diferentes peticiones:
 * https://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol#Request_methods
 */
switch($_SERVER['REQUEST_METHOD']) {
    // Consulta de datos
    case 'GET':
        try {
            // Comprobamos si es una consulta de un evento concreto -> eventos.php?idEvento=XXXXX
            $idEvento = filter_input(INPUT_GET, 'idEvento', FILTER_VALIDATE_INT);
            if ($idEvento) {
                $result = [];
                $result[] = Calendario::buscaEvento((int)$idEvento);
            } else {
                // Comprobamos si es una lista de eventos entre dos fechas -> eventos.php?start=XXXXX&end=YYYYY
                // https://fullcalendar.io/docs/events-json-feed
                $start = filter_input(INPUT_GET, 'start', FILTER_SANITIZE_SPECIAL_CHARS);
                $end = filter_input(INPUT_GET, 'end', FILTER_SANITIZE_SPECIAL_CHARS);
                if ($start) {
                    $startDateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $start);
                    $endDateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $end);
                    $result = Calendario::buscaEntreFechas(1, $startDateTime, $endDateTime);
                } else {
                    http_response_code(400);
                    echo 'Parámetros start o end incorrectos';
                    die();
                }
            }

            // Generamos un array de eventos en formato JSON
            $json = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

            http_response_code(200); // 200 OK
            header('Content-Type: application/json; charset=utf-8');
            header('Content-Length: ' . mb_strlen($json));

            echo $json;
        }catch(\Exception $e) {
            http_response_code(500);
            echo 'Error en la aplicación';
            error_log($e);
            die();
        }

    break;

    default:
        http_response_code(400);
        echo $_SERVER['REQUEST_METHOD']. ' no está soportado';
    break;
}