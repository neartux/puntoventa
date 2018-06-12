<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrintingFormatsConfiguration extends Model {

    protected $table = 'printing_formats_configurations';

    public $timestamps = false;

    /**
     * Get the printingformat record associated with the configuration.
     */
    public function printingFormat() {
        return $this->hasOne('App\Models\PrintingFormats', 'id', 'printing_format_id');
    }
}
