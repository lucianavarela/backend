<?php
class Resultado
{
    public $id;
    public $idUser;
    public $juego;
    public $nivel;
    public $tiempo;
    
    public function GetIdUser() {
        return $this->idUser;
    }
    public function GetJuego() {
        return $this->juego;
    }
    public function GetNivel() {
        return $this->nivel;
    }
    public function GetTiempo() {
        return $this->nivel;
    }

    public function SetIdUser($value) {
        $this->idUser = $value;
    }
    public function SetJuego($value) {
        $this->juego = $value;
    }
    public function SetNivel($value) {
        $this->nivel = $value;
    }
    public function SetTiempo($value) {
        $this->nivel = $value;
    }
    
    public function BorrarResultado() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            delete
            from resultado
            WHERE id=$this->id");
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ModificarResultado() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            update resultado 
            set idUser='$this->idUser',
            juego='$this->juego',
            nivel=$this->nivel,
            tiempo=$this->tiempo
            WHERE id=$this->id;");
        return $consulta->execute();
    }

    public function InsertarResultado() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT
        into resultado (idUser,juego,nivel,tiempo)
        values('$this->idUser','$this->juego',$this->nivel,$this->tiempo)");
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function GuardarResultado() {
        if ($this->id > 0) {
            $this->ModificarResultado();
        } else {
            $this->InsertarResultado();
        }
    }

    public static function TraerResultados() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "SELECT * FROM resultado INNER JOIN jugador ON jugador.id = resultado.idUser"
        );
        $consulta->execute();
        $resultados = $consulta->fetchAll(PDO::FETCH_CLASS, "Resultado");
        return $resultados;
    }

    public static function TraerFiltrados($resultado) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from resultado where resultado = $resultado");
        $consulta->execute();
        $resultadosFiltrados= $consulta->fetchAll(PDO::FETCH_CLASS, "Resultado");
        return $resultadosFiltrados;
    }
}