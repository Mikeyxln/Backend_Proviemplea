<?php

class modeloCandidato {

    private $ID_CANDIDATO;
    private $VCH_TITULO_PERFIL;
    private $VCH_DESCRIPCION;
    private $INT_ANIOS_EXPERIENCIA;
    private $INT_ACTIVO;

    public function __construct() {}

    public function getID_CANDIDATO() { return $this->ID_CANDIDATO; }
    public function setID_CANDIDATO($value) { $this->ID_CANDIDATO = $value; }

    public function getVCH_TITULO_PERFIL() { return $this->VCH_TITULO_PERFIL; }
    public function setVCH_TITULO_PERFIL($value) { $this->VCH_TITULO_PERFIL = $value; }

    public function getVCH_DESCRIPCION() { return $this->VCH_DESCRIPCION; }
    public function setVCH_DESCRIPCION($value) { $this->VCH_DESCRIPCION = $value; }

    public function getINT_ANIOS_EXPERIENCIA() { return $this->INT_ANIOS_EXPERIENCIA; }
    public function setINT_ANIOS_EXPERIENCIA($value) { $this->INT_ANIOS_EXPERIENCIA = $value; }

    public function getINT_ACTIVO() { return $this->INT_ACTIVO; }
    public function setINT_ACTIVO($value) { $this->INT_ACTIVO = $value; }

    public function getAll() {
        $lista = [];
        $con   = new Conexion();
        $query = "SELECT ID_CANDIDATO, VCH_TITULO_PERFIL, VCH_DESCRIPCION, 
                         INT_ANIOS_EXPERIENCIA, INT_ACTIVO 
                  FROM tbl_candidato";
        $rs = mysqli_query($con->getConnection(), $query);
        if ($rs) {
            while ($registro = mysqli_fetch_assoc($rs)) {
                $tupla = new modeloCandidato();
                $tupla->setID_CANDIDATO($registro['ID_CANDIDATO']);
                $tupla->setVCH_TITULO_PERFIL($registro['VCH_TITULO_PERFIL']);
                $tupla->setVCH_DESCRIPCION($registro['VCH_DESCRIPCION']);
                $tupla->setINT_ANIOS_EXPERIENCIA($registro['INT_ANIOS_EXPERIENCIA']);
                $tupla->setINT_ACTIVO($registro['INT_ACTIVO']);

                array_push($lista, [
                    'id'               => $tupla->getID_CANDIDATO(),
                    'titulo_perfil'    => $tupla->getVCH_TITULO_PERFIL(),
                    'descripcion'      => $tupla->getVCH_DESCRIPCION(),
                    'anios_experiencia'=> $tupla->getINT_ANIOS_EXPERIENCIA(),
                    'activo'           => $tupla->getINT_ACTIVO()
                ]);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $lista;
    }

    public function add(modeloCandidato $_nuevo) {
        $con = new Conexion();
        $stmt = mysqli_prepare(
            $con->getConnection(),
            "INSERT INTO tbl_candidato (VCH_TITULO_PERFIL, VCH_DESCRIPCION, INT_ANIOS_EXPERIENCIA, INT_ACTIVO)
             VALUES (?, ?, ?, 1)"
        );
        mysqli_stmt_bind_param(
            $stmt, 'ssi',
            $_nuevo->getVCH_TITULO_PERFIL(),
            $_nuevo->getVCH_DESCRIPCION(),
            $_nuevo->getINT_ANIOS_EXPERIENCIA()
        );
        $rs = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $con->closeConnection();
        return $rs ? true : false;
    }

    public function update(modeloCandidato $_nuevo) {
        $con  = new Conexion();
        $stmt = mysqli_prepare(
            $con->getConnection(),
            "UPDATE tbl_candidato SET 
                VCH_TITULO_PERFIL     = ?,
                VCH_DESCRIPCION       = ?,
                INT_ANIOS_EXPERIENCIA = ?
             WHERE ID_CANDIDATO = ?"
        );
        mysqli_stmt_bind_param(
            $stmt, 'ssii',
            $_nuevo->getVCH_TITULO_PERFIL(),
            $_nuevo->getVCH_DESCRIPCION(),
            $_nuevo->getINT_ANIOS_EXPERIENCIA(),
            $_nuevo->getID_CANDIDATO()
        );
        $rs = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $con->closeConnection();
        return $rs ? true : false;
    }

    public function delete(modeloCandidato $_nuevo) {
        $con  = new Conexion();
        $stmt = mysqli_prepare(
            $con->getConnection(),
            "DELETE FROM tbl_candidato WHERE ID_CANDIDATO = ?"
        );
        mysqli_stmt_bind_param($stmt, 'i', $_nuevo->getID_CANDIDATO());
        $rs = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $con->closeConnection();
        return $rs ? true : false;
    }

    public function toggleActivo(modeloCandidato $_nuevo) {
        $con  = new Conexion();
        $stmt = mysqli_prepare(
            $con->getConnection(),
            "UPDATE tbl_candidato SET INT_ACTIVO = IF(INT_ACTIVO = 1, 0, 1)
             WHERE ID_CANDIDATO = ?"
        );
        mysqli_stmt_bind_param($stmt, 'i', $_nuevo->getID_CANDIDATO());
        $rs = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $con->closeConnection();
        return $rs ? true : false;
    }
}
?>
