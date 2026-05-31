<?php

include_once '../v1.php';
include_once '../conexion.php';
include_once 'modeloHabilidad.php';

switch ($_method) {

    case 'GET':
        if ($_authorization === 'Bearer habilidades.get') {
            $modelo = new modeloHabilidad();
            http_response_code(200);
            echo json_encode(['data' => $modelo->getAll()]);
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    case 'POST':
        if ($_authorization === 'Bearer habilidades.post') {
            $body = json_decode(file_get_contents('php://input', true));
            if (!isset($body->VCH_NOMBRE_HABILIDAD) || !isset($body->VCH_CATEGORIA)) {
                http_response_code(400);
                echo json_encode(['type' => 'error', 'msg' => 'Datos incompletos']);
                break;
            }
            $modelo = new modeloHabilidad();
            $modelo->setVCH_NOMBRE_HABILIDAD($body->VCH_NOMBRE_HABILIDAD);
            $modelo->setVCH_CATEGORIA($body->VCH_CATEGORIA);
            $respuesta = $modelo->add($modelo);
            if ($respuesta) {
                http_response_code(201);
                echo json_encode(['type' => 'msg', 'msg' => 'Habilidad creada correctamente']);
            } else {
                http_response_code(422);
                echo json_encode(['type' => 'error', 'msg' => 'No se pudo crear la habilidad']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    case 'PUT':
        if ($_authorization === 'Bearer habilidades.put') {
            $body = json_decode(file_get_contents('php://input', true));
            if (!isset($body->ID_HABILIDAD) || !isset($body->VCH_NOMBRE_HABILIDAD) || !isset($body->VCH_CATEGORIA)) {
                http_response_code(400);
                echo json_encode(['type' => 'error', 'msg' => 'Datos incompletos']);
                break;
            }
            $modelo = new modeloHabilidad();
            $modelo->setID_HABILIDAD($body->ID_HABILIDAD);
            $modelo->setVCH_NOMBRE_HABILIDAD($body->VCH_NOMBRE_HABILIDAD);
            $modelo->setVCH_CATEGORIA($body->VCH_CATEGORIA);
            $respuesta = $modelo->update($modelo);
            if ($respuesta) {
                http_response_code(200);
                echo json_encode(['type' => 'msg', 'msg' => 'Habilidad actualizada correctamente']);
            } else {
                http_response_code(422);
                echo json_encode(['type' => 'error', 'msg' => 'No se pudo actualizar la habilidad']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    case 'DELETE':
        if ($_authorization === 'Bearer habilidades.delete') {
            $body = json_decode(file_get_contents('php://input', true));
            $id   = isset($body->ID_HABILIDAD) ? $body->ID_HABILIDAD : null;
            if ($id === null) {
                http_response_code(400);
                echo json_encode(['type' => 'error', 'msg' => 'ID requerido']);
                break;
            }
            $modelo = new modeloHabilidad();
            $modelo->setID_HABILIDAD($id);
            $respuesta = $modelo->delete($modelo);
            if ($respuesta) {
                http_response_code(200);
                echo json_encode(['type' => 'msg', 'msg' => 'Habilidad eliminada correctamente']);
            } else {
                http_response_code(422);
                echo json_encode(['type' => 'error', 'msg' => 'No se pudo eliminar la habilidad']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    case 'PATCH':
        if ($_authorization === 'Bearer habilidades.patch') {
            $body = json_decode(file_get_contents('php://input', true));
            $id   = isset($body->ID_HABILIDAD) ? $body->ID_HABILIDAD : null;
            if ($id === null) {
                http_response_code(400);
                echo json_encode(['type' => 'error', 'msg' => 'ID requerido']);
                break;
            }
            $modelo = new modeloHabilidad();
            $modelo->setID_HABILIDAD($id);
            $respuesta = $modelo->toggleActivo($modelo);
            if ($respuesta) {
                http_response_code(200);
                echo json_encode(['type' => 'msg', 'msg' => 'Estado de la habilidad actualizado']);
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
