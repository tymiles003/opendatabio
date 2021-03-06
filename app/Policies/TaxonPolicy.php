<?php

namespace App\Policies;

use App\User;
use App\Taxon;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxonPolicy
{
    use HandlesAuthorization;
    public function create(User $user)
    {
	    return $user->access_level >= User::USER;
        //
    }
    public function update(User $user, Taxon $taxon)
    {
	    return $user->access_level >= User::USER;
        //
    }

}
