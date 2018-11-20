<?php
class Usuario
{
    public $id;
    public $mail;
    public $clave;
    public $perfil;
    public $nombre;
    public $sexo;
    
    public function GetMail() {
        return $this->mail;
    }
    public function GetClave() {
        return $this->clave;
    }
    public function GetPerfil() {
        return $this->perfil;
    }
    public function GetNombre() {
        return $this->nombre;
    }
    public function GetSexo() {
        return $this->sexo;
    }

    public function SetMail($value) {
        $this->mail = $value;
    }
    public function SetClave($value) {
        $this->clave = $value;
    }
    public function SetPerfil($value) {
        $this->perfil = $value;
    }
    public function SetNombre($value) {
        $this->nombre = $value;
    }
    public function SetSexo($value) {
        $this->sexo = $value;
    }
    
    public function BorrarUsuario() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            delete
            from usuarios
            WHERE id=$this->id");
        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ModificarUsuario() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            update usuarios 
            set mail='$this->mail',
            clave='$this->clave',
            perfil='$this->perfil',
            nombre='$this->nombre',
            sexo='$this->sexo'
            WHERE id=$this->id;");
        return $consulta->execute();
    }

    public function InsertarUsuario() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT
        into usuarios (mail,clave,perfil,nombre,sexo)
        values('$this->mail','$this->clave','$this->perfil','$this->nombre','$this->sexo')");
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function GuardarUsuario() {
        if ($this->id > 0) {
            $this->ModificarUsuario();
        } else {
            $this->InsertarUsuario();
        }
    }

    public static function TraerUsuarios() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "SELECT * FROM usuarios"
        );
        $consulta->execute();
        $usuarios = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
        return $usuarios;
    }

    public static function TraerUsuario($id) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from usuarios where id = $id");
        $consulta->execute();
        $usuarioResultado= $consulta->fetchObject('Usuario');
        return $usuarioResultado;
    }

    public static function ValidarUsuario($mail, $clave, $nombre, $perfil) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta(
            "select * from usuarios where mail='$mail' and clave='$clave' and nombre='$nombre' and perfil='$perfil'");
        $consulta->execute();
        $usuarioResultado= $consulta->fetchObject('Usuario');
        return $usuarioResultado;
    }

    public function toString() {
        return "Metodo mostar:".$this->mail."  ".$this->clave."  ".$this->perfil;
    }
}