<?php namespace Simexis\Thumbalizr\Facades;

use Illuminate\Support\Facades\Facade;

class Thumbalizr extends Facade {
	/**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return '\Simexis\Thumbalizr\Thumbalizr'; }

}