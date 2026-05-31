<?php

include_once '../v1.php';
include_once '../conexion.php';
include_once 'modeloEmpresa.php';

switch ($_method) {

    case 'GET':
        if ($_authorization === 'Bearer empresas.get') {
            $modelo = new modeloEmpresa();
            http_response_code(200);
            echo json_encode(['data' => $modelo->getAll()]);
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    case 'POST':
        if ($_authorization === 'Bearer empresas.post') {
            $body = json_decode(file_get_contents('php://input', true));
            if (!isset($body->VCH_NOMBRE_EMPRESA) || !isset($body->VCH_RUBRO) || !isset($body->VCH_DESCRIPCION)) {
                http_response_code(400);
                echo json_encode(['type' => 'error', 'msg' => 'Datos incompletos']);
                break;
            }
            $modelo = new modeloEmpresa();
            $modelo->setVCH_NOMBRE_EMPRESA($body->VCH_NOMBRE_EMPRESA);
            $modelo->setVCH_RUBRO($body->VCH_RUBRO);
            $modelo->setVCH_DESCRIPCION($body->VCH_DESCRIPCION);
            $respuesta = $modelo->add($modelo);
            if ($respuesta) {
                http_response_code(201);
                echo json_encode(['type' => 'msg', 'msg' => 'Empresa creada correctamente']);
            } else {
                http_response_code(422);
                echo json_encode(['type' => 'error', 'msg' => 'No se pudo crear la empresa']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    case 'PUT':
        if ($_authorization === 'Bearer empresas.put') {
            $body = json_decode(file_get_contents('php://input', true));
            if (!isset($body->ID_EMPRESA) || !isset($body->VCH_NOMBRE_EMPRESA) ||
                !isset($body->VCH_RUBRO)  || !isset($body->VCH_DESCRIPCION)) {
                http_response_code(400);
                echo json_encode(['type' => 'error', 'msg' => 'Datos incompletos']);
                break;
            }
            $modelo = new modeloEmpresa();
            $modelo->setID_EMPRESA($body->ID_EMPRESA);
            $modelo->setVCH_NOMBRE_EMPRESA($body->VCH_NOMBRE_EMPRESA);
            $modelo->setVCH_RUBRO($body->VCH_RUBRO);
            $modelo->setVCH_DESCRIPCION($body->VCH_DESCRIPCION);
            $respuesta = $modelo->update($modelo);
            if ($respuesta) {
                http_response_code(200);
                echo json_encode(['type' => 'msg', 'msg' => 'Empresa actualizada correctamente']);
            } else {
                http_response_code(422);
                echo json_encode(['type' => 'error', 'msg' => 'No se pudo actualizar la empresa']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    case 'DELETE':
        if ($_authorization === 'Bearer empresas.delete') {
            $body = json_decode(file_get_contents('php://input', true));
            $id   = isset($body->ID_EMPRESA) ? $body->ID_EMPRESA : null;
            if ($id === null) {
                http_response_code(400);
                echo json_encode(['type' => 'error', 'msg' => 'ID requerido']);
                break;
            }
            $modelo = new modeloEmpresa();
            $modelo->setID_EMPRESA($id);
            $respuesta = $modelo->delete($modelo);
            if ($respuesta) {
                http_response_code(200);
                echo json_encode(['type' => 'msg', 'msg' => 'Empresa eliminada correctamente']);
            } else {
                http_response_code(422);
                echo json_encode(['type' => 'error', 'msg' => 'No se pudo eliminar la empresa']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['type' => 'error', 'msg' => 'Acceso Prohibido']);
        }
        break;

    case 'PATCH':
        if ($_authorization === 'Bearer empresas.patch') {
            $body = json_decode(file_get_contents('php://input', true));
            $id   = isset($body->ID_EMPRESA) ? $body->ID_EMPRESA : null;
            if ($id === null) {
                http_response_code(400);
                echo json_encode(['type' => 'error', 'msg' => 'ID requerido']);
                break;
            }
            $modelo = new modeloEmpresa();
            $modelo->setID_EMPRESA($id);
            $respuesta = $modelo->toggleActivo($modelo);
            if ($respuesta) {
                http_response_code(200);
                echo json_encode(['type' => 'msg', 'msg' => 'Estado de la empresa actualizado']);
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
