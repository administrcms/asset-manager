<?php

namespace Administr\Assets;


use Illuminate\Support\Facades\Facade;

class AssetsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'administr.assets';
    }
}