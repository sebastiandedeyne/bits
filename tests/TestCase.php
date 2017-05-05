<?php

namespace Bits\Bits\Test;

use Bits\Bits\BitsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');

        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('bits.types', [
            'text' => Text::class,
        ]);
    }

    protected function setUpDatabase()
    {
        require_once __DIR__.'/../database/migrations/create_bits_table.php.stub';

        (new \CreateBitsTable())->up();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            BitsServiceProvider::class,
        ];
    }
}
