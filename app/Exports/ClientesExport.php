<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClientesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $filtros = json_decode($this->request['filtros']);

        $users = User::ClientesApp()
            ->join('ciudades', 'users.idciudad', '=', 'ciudades.id')
            ->join('roles', 'users.idrol', '=', 'roles.id')
            ->join('tipos_documentos', 'users.idtipos_documento', '=', 'tipos_documentos.id')
            ->join('empresas', 'users.idempresa', '=', 'empresas.id');

        if (!is_null($filtros)) {
            if (!is_null($filtros->documento) && $filtros->documento <> '') {
                $users = $users->where('users.documento', 'like', '%' . $filtros->documento . '%');
            }

            if (!is_null($filtros->nombre) && $filtros->nombre <> '') {
                $users = $users->where('users.nombre', 'like', '%' . $filtros->nombre . '%');
            }

            if (!is_null($filtros->apellido) && $filtros->apellido <> '') {
                $users = $users->where('users.apellido', 'like', '%' . $filtros->apellido . '%');
            }

            if (!is_null($filtros->correo) && $filtros->correo <> '') {
                $users = $users->where('users.correo', 'like', '%' . $filtros->correo . '%');
            }

            if (!is_null($filtros->movil) && $filtros->movil <> '') {
                $users = $users->where('users.movil', 'like', '%' . $filtros->movil . '%');
            }

            if (!is_null($filtros->idrol) && $filtros->idrol <> '' && $filtros->idrol <> 0) {
                $users = $users->where('users.idrol', 'like', '%' . $filtros->idrol . '%');
            }
        }
        return $users->select('users.nombre as nombre',
            'users.apellido as apellido',
            'tipos_documentos.nombre as tipo_documento',
            'users.documento as documento',
            'users.correo as correo',
            'users.telefono as telefono',
            'users.movil as movil',
            'users.username as username',
            'ciudades.nombre as ciudad',
            'users.direccion as direccion',
            'roles.nombre as rol',
            'empresas.razon_social as empresa')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Apellido',
            'Tipo_documento',
            'Documento',
            'Correo',
            'Teléfono',
            'Movil',
            'Username',
            'Ciudad',
            'Dirección',
            'Rol',
            'Empresa'
        ];
    }
}
