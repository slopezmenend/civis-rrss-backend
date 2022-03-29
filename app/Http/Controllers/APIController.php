<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CongresoRepositoryInterface;

class APIController extends Controller
{

    public function getAllDiputados()//: JsonResponse
    {
        $data = $this->congresoRepository->getAllDiputados();
        if ($data != null)
            return response()->json(['data' => $data ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getDiputadoById($id)//: JsonResponse
    {
        $data = $this->congresoRepository->getDiputadoById($id);
        if ($data != null)
            return response()->json(['data' => $data ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getDiputadoByName($nombre)//: JsonResponse
    {
        $data = $this->congresoRepository->getDiputadoByName($nombre);
        if ($data != null)
            return response()->json(['data' => $data ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getAllVotacionesSummary()//: JsonResponse
    {
        $data = $this->congresoRepository->getAllVotacionesSummary();
        if ($data != null)
            return response()->json(['data' => $data ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getVotacionesSummaryByDate($date)//: JsonResponse
    {
        $data = $this->congresoRepository->getVotacionesSummaryByDate($date);
        if ($data != null)
            return response()->json(['data' => $data ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getVotacionDetail($id)
    //: JsonResponse
    {
        $data = $this->congresoRepository->getVotacionDetail($id);
        if ($data != null)
            return response()->json(['data' => $data ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getVotacionDetailVotos($id)
    //: JsonResponse
    {
        $data = $this->congresoRepository->getVotacionDetailVotos($id);
        if ($data != null)
            return response()->json(['data' => $data ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getVotacionesSumaryByDiputadoId ($id)//: JsonResponse
    {
        $data = $this->congresoRepository->getVotacionesSumaryByDiputadoId ($id);
        if ($data != null)
            return response()->json(['data' => $data ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getAllIntervenciones()//: JsonResponse
    {
        $data = $this->congresoRepository->getAllIntervenciones();
        if ($data != null)
            return response()->json(['data' => $data ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getIntervencionesByDate($date)//: JsonResponse
    {
        $data = $this->congresoRepository->getIntervencionesByDate($date);
        if ($data != null)
            return response()->json(['data' => $data ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getIntervencion($id)//: JsonResponse
    {
        $data = $this->congresoRepository->getIntervencion($id);
        if ($data != null)
            return response()->json(['data' => $data ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }

    public function getIntervencionByDiputadoId ($id)//: JsonResponse
    {
        $data = $this->congresoRepository->getIntervencionByDiputadoId($id);
            if ($data != null)
            return response()->json(['data' => $data ]);
        else
            return response()->json(['message' => 'Not Found!'], 404);
    }
}
