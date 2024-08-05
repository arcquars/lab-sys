<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class TestInputAbstract extends Model
{
    public abstract function getHtmlInput($aTestResultId): string;
    public abstract function getHtmlDescription(): string;
    public abstract function getHtmlResult($aTestResultId, $result): string;
    public abstract function getHtmlDescriptionResult($aTestResultId): string;
}
