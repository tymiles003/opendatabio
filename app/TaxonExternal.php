<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxonExternal extends Model
{
        protected $table = 'taxon_external';
        protected $fillable = ['name', 'taxon_id', 'reference'];
    //
}
