<?php

namespace App\Http\Services;

use App\Exceptions\NoAvailableEquipmentException;
use App\Exceptions\ShoeSizeNotSupportedException;
use App\Exceptions\WeightNotSupportedException;
use App\Model\Cliente;
use App\Model\Evento;
use App\Model\SesionCliente;
use App\Utils\KangooResistancesEnum;
use App\Utils\KangooStatesEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KangooService
{
    /**
     * @throws ShoeSizeNotSupportedException
     * @throws WeightNotSupportedException
     * @throws NoAvailableEquipmentException
     */
    public function assignKangoo(int $shoeSize, int $weight, $startDateTime, $endDateTime)
    {

        $kangooSizes = $this->getKangooSizes($shoeSize);
        $resistance = $this->getKangooResistance($weight);

        $assignedKangooId = DB::table('kangoos')->whereNotIn('id', function($q) use($startDateTime, $endDateTime){
            $q->select('kangoos.id')->from('kangoos')
                ->leftJoin('sesiones_cliente', 'kangoos.id', '=', 'sesiones_cliente.kangoo_id')
                ->where('sesiones_cliente.fecha_fin', '>=', Carbon::parse($startDateTime)->format('Y-m-d H:i:s'))
                ->where('sesiones_cliente.fecha_inicio', '<=', Carbon::parse($endDateTime)->format('Y-m-d H:i:s'))
                ->whereNull('deleted_at');
        })->where('kangoos.estado', KangooStatesEnum::Available)
            ->whereIn('talla', $kangooSizes)
            ->where('kangoos.resistencia', '>=', $resistance)
            ->orderBy('kangoos.resistencia')
            ->select('kangoos.id')
            ->first();

        if (!$assignedKangooId){
            throw new NoAvailableEquipmentException();
        }

        return $assignedKangooId->id;
    }

    /**
     * @throws ShoeSizeNotSupportedException
     */
    public function getKangooSizes(int $shoeSize)
    {
        switch ($shoeSize){
            case 34:
            case 35:
            case 36:
                return ["XS", "S"];
            case 37:
            case 38:
            case 39:
                return ["S", "M"];
            case 40:
            case 41:
                return ["M", "L"];
            case 42:
            case 43:
            case 44:
                return ["L"];
            default:
                throw new ShoeSizeNotSupportedException();
        }
    }

    /**
     * @throws WeightNotSupportedException
     */
    public function getKangooResistance($weight)
    {
        if ($weight < 55){
            $resistance = 1;
        }elseif ($weight < 65) {
            $resistance = 2;
        }elseif ($weight < 76) {
            $resistance = 3;
        } elseif ($weight < 80) {
            $resistance = 4;
        } elseif ($weight > 80) {
            $resistance = 5;
        }else{
           throw new WeightNotSupportedException();
        }
        return $resistance;
    }

}