<?php
namespace App\Traits;

use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

trait Transactional
{
    public function executeTransaction(callable $callback): array
    {
        try {
            DB::beginTransaction();
            $result = $callback();
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->response($e->getMessage(), false);
        }
    }
    #[ArrayShape(['status' => "", 'message' => ""])]
    protected function response($message, $success): array
    {
        return [
            'status' => $success,
            'message' => $message
        ];
    }
}
