<?php

include_once '../v1.php';     
// DEBUG TEMPORAL - borrar después
// die(json_encode(['token_recibido' => $_authorization]));
include_once '../conexion.php'; 
include_once 'modeloCandidato.php';

switch ($_method) {
    case 'GET':
        if ($_authorization === 'Bearer candidatos.get') {
            $modelo = new modeloCandidato();
            http_response_code(200);
            echo json_encode(['data' => $modelo->getAll()]);
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    case 'POST':
        if ($_authorization === 'Bearer candidatos.post') {
            $body = json_decode(file_get_contents('php://input', true));
            if (!isset($body->VCH_TITULO_PERFIL) || !isset($body->VCH_DESCRIPCION) || !isset($body->INT_ANIOS_EXPERIENCIA)) {
                http_response_code(400);
                echo json_encode(['type' => 'error', 'msg' => 'Datos incompletos']);
                break;
            }
            $modelo = new modeloCandidato();
            $modelo->setVCH_TITULO_PERFIL($body->VCH_TITULO_PERFIL);
            $modelo->setVCH_DESCRIPCION($body->VCH_DESCRIPCION);
            $modelo->setINT_ANIOS_EXPERIENCIA($body->INT_ANIOS_EXPERIENCIA);
            $respuesta = $modelo->add($modelo);
            if ($respuesta) {
                http_response_code(201);
                echo json_encode(['type' => 'msg', 'msg' => 'Candidato creado correctamente']);
            } else {
                http_response_code(422);
                echo json_encode(['type' => 'error', 'msg' => 'No se pudo crear el candidato']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    case 'PUT':
        if ($_authorization === 'Bearer candidatos.put') {
            $body = json_decode(file_get_contents('php://input', true));
            if (!isset($body->ID_CANDIDATO) || !isset($body->VCH_TITULO_PERFIL) ||
                !isset($body->VCH_DESCRIPCION) || !isset($body->INT_ANIOS_EXPERIENCIA)) {
                http_response_code(400);
                echo json_encode(['type' => 'error', 'msg' => 'Datos incompletos']);
                break;
            }
            $modelo = new modeloCandidato();
            $modelo->setID_CANDIDATO($body->ID_CANDIDATO);
            $modelo->setVCH_TITULO_PERFIL($body->VCH_TITULO_PERFIL);
            $modelo->setVCH_DESCRIPCION($body->VCH_DESCRIPCION);
            $modelo->setINT_ANIOS_EXPERIENCIA($body->INT_ANIOS_EXPERIENCIA);
            $respuesta = $modelo->update($modelo);
            if ($respuesta) {
                http_response_code(200);
                echo json_encode(['type' => 'msg', 'msg' => 'Candidato actualizado correctamente']);
            } else {
                http_response_code(422);
                echo json_encode(['type' => 'error', 'msg' => 'No se pudo actualizar el candidato']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    case 'DELETE':
        if ($_authorization === 'Bearer candidatos.delete') {
            $body = json_decode(file_get_contents('php://input', true));
            $id   = isset($body->ID_CANDIDATO) ? $body->ID_CANDIDATO : null;
            if ($id === null) {
                http_response_code(400);
                echo json_encode(['type' => 'error', 'msg' => 'ID requerido']);
                break;
            }
            $modelo = new modeloCandidato();
            $modelo->setID_CANDIDATO($id);
            $respuesta = $modelo->delete($modelo);
            if ($respuesta) {
                http_response_code(200);
                echo json_encode(['type' => 'msg', 'msg' => 'Candidato eliminado correctamente']);
            } else {
                http_response_code(422);
                echo json_encode(['type' => 'error', 'msg' => 'No se pudo eliminar el candidato']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    case 'PATCH':
        if ($_authorization === 'Bearer candidatos.patch') {
            $body = json_decode(file_get_contents('php://input', true));
            $id   = isset($body->ID_CANDIDATO) ? $body->ID_CANDIDATO : null;
            if ($id === null) {
                http_response_code(400);
                echo json_encode(['type' => 'error', 'msg' => 'ID requerido']);
                break;
            }
            $modelo = new modeloCandidato();
            $modelo->setID_CANDIDATO($id);
            $respuesta = $modelo->toggleActivo($modelo);
            if ($respuesta) {
                http_response_code(200);
                echo json_encode(['type' => 'msg', 'msg' => 'Estado del candidato actualizado']);
            } else {
                http_response_code(422);
                echo json_encode(['type' => 'error', 'msg' => 'No se pudo actualizar el estado']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    default:
        http_response_code(501);
        echo json_encode(['type' => 'error', 'msg' => 'Metodo No Implementado']);
        break;
}
?>
