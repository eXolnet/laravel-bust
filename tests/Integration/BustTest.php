<?php

namespace Exolnet\Bust\Tests\Integration;

use Exolnet\Bust\Bust;

class BustTest extends TestCase
{
    /**
     * @var \Exolnet\Bust\Bust
     */
    protected $bust;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('bust.base_path', realpath(__DIR__ . '/../Mocks'));

        $this->bust = app()->make(Bust::class);
    }

    /**
     * @return void
     * @test
     */
    public function testAsset(): void
    {
        $asset = $this->bust->asset('example.css');

        $this->assertMatchesRegularExpression('#/example\.[0-9]+\.css$#', $asset);
    }

    /**
     * @return void
     * @test
     */
    public function testAssetWithQueryParameter(): void
    {
        $this->app['config']->set('bust.query_parameter_version', 'v');

        $asset = $this->bust->asset('example.css');

        $this->assertMatchesRegularExpression('#/example\.css\?v=[0-9]+$#', $asset);
    }

    /**
     * @return void
     * @test
     */
    public function testAssetWithoutExtension(): void
    {
        $asset = $this->bust->asset('example');

        $this->assertMatchesRegularExpression('#example$#', $asset);
    }

    /**
     * @return void
     * @test
     */
    public function testFilename(): void
    {
        $filename = $this->bust->filename('example.css');

        $this->assertMatchesRegularExpression('#example\.[0-9]+\.css#', $filename);
    }
}
