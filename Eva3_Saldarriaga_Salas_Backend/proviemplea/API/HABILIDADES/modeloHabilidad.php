<?php

class modeloHabilidad {

    private $ID_HABILIDAD;
    private $VCH_NOMBRE_HABILIDAD;
    private $VCH_CATEGORIA;
    private $INT_ACTIVO;

    public function __construct() {}

    public function getID_HABILIDAD() { return $this->ID_HABILIDAD; }
    public function setID_HABILIDAD($value) { $this->ID_HABILIDAD = $value; }

    public function getVCH_NOMBRE_HABILIDAD() { return $this->VCH_NOMBRE_HABILIDAD; }
    public function setVCH_NOMBRE_HABILIDAD($value) { $this->VCH_NOMBRE_HABILIDAD = $value; }

    public function getVCH_CATEGORIA() { return $this->VCH_CATEGORIA; }
    public function setVCH_CATEGORIA($value) { $this->VCH_CATEGORIA = $value; }

    public function getINT_ACTIVO() { return $this->INT_ACTIVO; }
    public function setINT_ACTIVO($value) { $this->INT_ACTIVO = $value; }

    public function getAll() {
        $lista = [];
        $con   = new Conexion();
        $query = "SELECT ID_HABILIDAD, VCH_NOMBRE_HABILIDAD, VCH_CATEGORIA, INT_ACTIVO 
                  FROM tbl_habilidad";
        $rs = mysqli_query($con->getConnection(), $query);
        if ($rs) {
            while ($registro = mysqli_fetch_assoc($rs)) {
                $tupla = new modeloHabilidad();
                $tupla->setID_HABILIDAD($registro['ID_HABILIDAD']);
                $tupla->setVCH_NOMBRE_HABILIDAD($registro['VCH_NOMBRE_HABILIDAD']);
                $tupla->setVCH_CATEGORIA($registro['VCH_CATEGORIA']);
                $tupla->setINT_ACTIVO($registro['INT_ACTIVO']);

                array_push($lista, [
                    'id'              => $tupla->getID_HABILIDAD(),
                    'nombre_habilidad'=> $tupla->getVCH_NOMBRE_HABILIDAD(),
                    'categoria'       => $tupla->getVCH_CATEGORIA(),
                    'activo'          => $tupla->getINT_ACTIVO()
                ]);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $lista;
    }

    public function add(modeloHabilidad $_nuevo) {
        $con  = new Conexion();
        $stmt = mysqli_prepare(
            $con->getConnection(),
            "INSERT INTO tbl_habilidad (VCH_NOMBRE_HABILIDAD, VCH_CATEGORIA, INT_ACTIVO)
             VALUES (?, ?, 1)"
        );
        mysqli_stmt_bind_param(
            $stmt, 'ss',
            $_nuevo->getVCH_NOMBRE_HABILIDAD(),
            $_nuevo->getVCH_CATEGORIA()
        );
        $rs = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $con->closeConnection();
        return $rs ? true : false;
    }

    public function update(modeloHabilidad $_nuevo) {
        $con  = new Conexion();
        $stmt = mysqli_prepare(
            $con->getConnection(),
            "UPDATE tbl_habilidad SET 
                VCH_NOMBRE_HABILIDAD = ?,
                VCH_CATEGORIA        = ?
             WHERE ID_HABILIDAD = ?"
        );
        mysqli_stmt_bind_param(
            $stmt, 'ssi',
            $_nuevo->getVCH_NOMBRE_HABILIDAD(),
            $_nuevo->getVCH_CATEGORIA(),
            $_nuevo->getID_HABILIDAD()
        );
        $rs = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $con->closeConnection();
        return $rs ? true : false;
    }

    public function delete(modeloHabilidad $_nuevo) {
        $con  = new Conexion();
        $stmt = mysqli_prepare(
            $con->getConnection(),
            "DELETE FROM tbl_habilidad WHERE ID_HABILIDAD = ?"
        );
        mysqli_stmt_bind_param($stmt, 'i', $_nuevo->getID_HABILIDAD());
        $rs = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $con->closeConnection();
        return $rs ? true : false;
    }

    public function toggleActivo(modeloHabilidad $_nuevo) {
        $con  = new Conexion();
        $stmt = mysqli_prepare(
            $con->getConnection(),
            "UPDATE tbl_habilidad SET INT_ACTIVO = IF(INT_ACTIVO = 1, 0, 1)
             WHERE ID_HABILIDAD = ?"
        );
        mysqli_stmt_bind_param($stmt, 'i', $_nuevo->getID_HABILIDAD());
        $rs = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $con->closeConnection();
        return $rs ? true : false;
    }
}
?>
