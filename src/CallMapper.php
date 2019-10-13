<?php
namespace Hllizi\CallMapper;
/**
 * Created by PhpStorm.
 * User: dlahm
 * Date: 20.03.19
 * Time: 12:22
 */

use Hllizi\PHPMonads\ArrayMonad;
use Hllizi\PHPMonads\MonadTrait;

class CallMapper extends ArrayMonad
{
    use MonadTrait;
    use CallMapIterator;
}
