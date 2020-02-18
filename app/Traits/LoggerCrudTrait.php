<?php

namespace App\Traits;

use App\Http\Controllers\Helper\GeneralHelper as Helper;

trait LoggerCrudTrait {
    
    protected $loggerCrud;

    public function setLogger(LoggerCrudRepositoryInterface $loggerCrud) {
        $this->loggerCrud = $loggerCrud;
    }

    public function makeCrudLogger(string $operation, string $model, string $content) {
        
    }

}