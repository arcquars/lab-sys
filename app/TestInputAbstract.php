<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class TestInputAbstract extends Model
{
    public abstract function getHtmlInput(): string;
    public abstract function getHtmlDescription(): string;
}
