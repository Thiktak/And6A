<?php

namespace And6a\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class And6aUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}
