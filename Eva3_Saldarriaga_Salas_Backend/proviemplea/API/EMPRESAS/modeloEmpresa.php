<?php

class modeloEmpresa {

    private $ID_EMPRESA;
    private $VCH_NOMBRE_EMPRESA;
    private $VCH_RUBRO;
    private $VCH_DESCRIPCION;
    private $INT_ACTIVO;

    public function __construct() {}

    public function getID_EMPRESA() { return $this->ID_EMPRESA; }
    public function setID_EMPRESA($value) { $this->ID_EMPRESA = $value; }

    public function getVCH_NOMBRE_EMPRESA() { return $this->VCH_NOMBRE_EMPRESA; }
    public function setVCH_NOMBRE_EMPRESA($value) { $this->VCH_NOMBRE_EMPRESA = $value; }

    public function getVCH_RUBRO() { return $this->VCH_RUBRO; }
    public function setVCH_RUBRO($value) { $this->VCH_RUBRO = $value; }

    public function getVCH_DESCRIPCION() { return $this->VCH_DESCRIPCION; }
    public function setVCH_DESCRIPCION($value) { $this->VCH_DESCRIPCION = $value; }

    public function getINT_ACTIVO() { return $this->INT_ACTIVO; }
    public function setINT_ACTIVO($value) { $this->INT_ACTIVO = $value; }

    public function getAll() {
        $lista = [];
        $con   = new Conexion();
        $query = "SELECT ID_EMPRESA, VCH_NOMBRE_EMPRESA, VCH_RUBRO, VCH_DESCRIPCION, INT_ACTIVO 
                  FROM tbl_empresa";
        $rs = mysqli_query($con->getConnection(), $query);
        if ($rs) {
            while ($registro = mysqli_fetch_assoc($rs)) {
                $tupla = new modeloEmpresa();
                $tupla->setID_EMPRESA($registro['ID_EMPRESA']);
                $tupla->setVCH_NOMBRE_EMPRESA($registro['VCH_NOMBRE_EMPRESA']);
                $tupla->setVCH_RUBRO($registro['VCH_RUBRO']);
                $tupla->setVCH_DESCRIPCION($registro['VCH_DESCRIPCION']);
                $tupla->setINT_ACTIVO($registro['INT_ACTIVO']);

                array_push($lista, [
                    'id'            => $tupla->getID_EMPRESA(),
                    'nombre_empresa'=> $tupla->getVCH_NOMBRE_EMPRESA(),
                    'rubro'         => $tupla->getVCH_RUBRO(),
                    'descripcion'   => $tupla->getVCH_DESCRIPCION(),
                    'activo'        => $tupla->getINT_ACTIVO()
                ]);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $lista;
    }

    public function add(modeloEmpresa $_nuevo) {
        $con  = new Conexion();
        $stmt = mysqli_prepare(
            $con->getConnection(),
            "INSERT INTO tbl_empresa (VCH_NOMBRE_EMPRESA, VCH_RUBRO, VCH_DESCRIPCION, INT_ACTIVO)
             VALUES (?, ?, ?, 1)"
        );
        mysqli_stmt_bind_param(
            $stmt, 'sss',
            $_nuevo->getVCH_NOMBRE_EMPRESA(),
            $_nuevo->getVCH_RUBRO(),
            $_nuevo->getVCH_DESCRIPCION()
        );
        $rs = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $con->closeConnection();
        return $rs ? true : false;
    }

    public function update(modeloEmpresa $_nuevo) {
        $con  = new Conexion();
        $stmt = mysqli_prepare(
            $con->getConnection(),
            "UPDATE tbl_empresa SET 
                VCH_NOMBRE_EMPRESA = ?,
                VCH_RUBRO          = ?,
                VCH_DESCRIPCION    = ?
             WHERE ID_EMPRESA = ?"
        );
        mysqli_stmt_bind_param(
            $stmt, 'sssi',
            $_nuevo->getVCH_NOMBRE_EMPRESA(),
            $_nuevo->getVCH_RUBRO(),
            $_nuevo->getVCH_DESCRIPCION(),
            $_nuevo->getID_EMPRESA()
        );
        $rs = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $con->closeConnection();
        return $rs ? true : false;
    }

    public function delete(modeloEmpresa $_nuevo) {
        $con  = new Conexion();
        $stmt = mysqli_prepare(
            $con->getConnection(),
            "DELETE FROM tbl_empresa WHERE ID_EMPRESA = ?"
        );
        mysqli_stmt_bind_param($stmt, 'i', $_nuevo->getID_EMPRESA());
        $rs = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $con->closeConnection();
        return $rs ? true : false;
    }

    public function toggleActivo(modeloEmpresa $_nuevo) {
        $con  = new Conexion();
        $stmt = mysqli_prepare(
            $con->getConnection(),
            "UPDATE tbl_empresa SET INT_ACTIVO = IF(INT_ACTIVO = 1, 0, 1)
             WHERE ID_EMPRESA = ?"
        );
        mysqli_stmt_bind_param($stmt, 'i', $_nuevo->getID_EMPRESA());
        $rs = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $con->closeConnection();
        return $rs ? true : false;
    }
}
?>
