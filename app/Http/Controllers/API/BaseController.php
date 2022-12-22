<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use stdClass;

class BaseController extends Controller
{
	private static $pagination;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function response($success, $data, $errors,$msg,$code = 200)
    {
        $data = [
            'success' => $success,
            'data'=> $data,
            'message' => $msg,
            'paging' => self::$pagination ?: new stdClass(),
            'errors' => $errors
        ];
        
        return response()->json($data, $code, ['Content-type'=> 'application/json; charset=utf-8'], JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_UNICODE);
    }

    public static function setPagination(LengthAwarePaginator $paginator)
    {
        self::$pagination                = new stdClass();
        self::$pagination->total_records = (int)$paginator->total();
        self::$pagination->current_page  = (int)$paginator->currentPage();
        self::$pagination->total_pages   = (int)$paginator->lastPage();
        self::$pagination->limit         = (int)$paginator->perPage();

        return new static;
    }

}
