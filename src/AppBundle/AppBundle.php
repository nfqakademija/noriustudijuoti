<?php

namespace AppBundle;

use AppBundle\DependencyInjection\AppExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function getExtension()
    {
        return new AppExtension;
    }
}
