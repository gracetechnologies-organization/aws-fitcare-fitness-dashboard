<?php

namespace App\Services;

class PaginationManipulationClass
{
    public static function getPaginationKeys(object $Paginator)
    {
        return [
            'currentPage' => $Paginator->currentPage(),
            'getOptions' => $Paginator->getOptions(),
            'hasMorePages' => $Paginator->hasMorePages(),
            'nextPageUrl' => $Paginator->nextPageUrl(),
            'previousPageUrl' => $Paginator->previousPageUrl(),
            'perPage' => $Paginator->perPage(),
            'total' => $Paginator->total(),
        ];
    }
}
