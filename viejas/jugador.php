<?php
class Jugador
{
    public $id;
    public $usuario;
    public $clave;
    public $nombre;
    
    public function GetUsuario() {
        return $this->usuario;
    }
    public function GetClave() {
        return $this->clave;
    }
    public function GetNombre() {
        return $this->nombre;
    }

    public function SetUsuario($value) {
        $this->usuario = $value;
    }
    public function SetClave($value) {
        $this->clave = $value;
    }
    public function SetNombre($value) {
        $this->nombre = $value;
    }
    
    public function BorrarJugador() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            delete
            from jugador
            WHERE id=$this->id");
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ModificarJugador() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            update jugador 
            set usuario='$this->usuario',
            clave='$this->clave',
            nombre='$this->nombre',
            WHERE id=$this->id;");
        return $consulta->execute();
    }

    public function InsertarJugador() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT
        into jugador (usuario,clave,nombre)
        values('$this->usuario','$this->clave','$this->nombre')");
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function GuardarJugador() {
        if ($this->id > 0) {
            $this->ModificarJugador();
        } else {
            $this->InsertarJugador();
        }
    }

    public static function TraerJugadores() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "SELECT * FROM jugador WHERE usuario != 'admin'"
        );
        $consulta->execute();
        $jugador = $consulta->fetchAll(PDO::FETCH_CLASS, "Jugador");
        return $jugador;
    }

    public static function TraerJugador($id) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from jugador where id = $id");
        $consulta->execute();
        $jugadorResultado= $consulta->fetchObject('Jugador');
        return $jugadorResultado;
    }

    public static function ValidarJugador($usuario, $clave) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from jugador where usuario='$usuario' and clave='$clave'");
        $consulta->execute();
        $jugadorResultado= $consulta->fetchObject('Jugador');
        return $jugadorResultado;
    }

    public function toString() {
        return "Metodo mostar:".$this->usuario."  ".$this->clave."  ".$this->nombre;
    }
}