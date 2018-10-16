<?php

namespace AppBundle\Tests\Service;

use PHPUnit\Framework\TestCase;

class ValiderEmailTest extends TestCase
{
    protected $email = "chaabani.hammadi@gmail.com";

    public function testValiderEmail()
    {
      $kernel = static::createKernel();

      $kernel->boot();

      $container = $kernel->getContainer();

      $service = $container->get('valider_email');

      $result = $service->validerEmail($this->email);

      $this->assertEquals("Cet email est correct.", $result);
    }

}
