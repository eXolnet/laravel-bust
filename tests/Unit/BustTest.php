<?php

namespace Exolnet\Bust\Tests\Unit;

use Exolnet\Bust\Bust;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Filesystem\Filesystem;
use Mockery as m;

class BustTest extends UnitTest
{
    /**
     * @var \Illuminate\Contracts\Config\Repository|\Mockery\MockInterface
     */
    protected $config;

    /**
     * @var \Illuminate\Filesystem\Filesystem|\Mockery\MockInterface
     */
    protected $filesystem;

    /**
     * @var \Illuminate\Contracts\Routing\UrlGenerator|\Mockery\MockInterface
     */
    protected $url;

    /**
     * @var \Exolnet\Bust\Bust
     */
    protected $bust;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->config = m::mock(ConfigRepository::class);
        $this->filesystem = m::mock(Filesystem::class);
        $this->url = m::mock(UrlGenerator::class);

        $this->bust = new Bust($this->config, $this->filesystem, $this->url);
    }

    /**
     * @return void
     */
    public function testClassIsInitialized(): void
    {
        $this->assertInstanceOf(Bust::class, $this->bust);
    }

    /**
     * @return void
     */
    public function testAssetWhenFileDoesNotExists(): void
    {
        $this->config->shouldReceive('get')->with('bust.base_path')->andReturn('/base/path');
        $this->filesystem->shouldReceive('exists')->with('/base/path/example.css')->andReturn(false);
        $this->url->shouldReceive('asset')->with('example.css', null)->andReturn('example.css');

        $actual = $this->bust->asset('example.css');

        $this->assertEquals('example.css', $actual);
    }

    /**
     * @return void
     */
    public function testAssetCanAppendVersionBeforeTheExtension(): void
    {
        $this->config->shouldReceive('get')->with('bust.base_path')->andReturn('/base/path');
        $this->config->shouldReceive('get')->with('bust.query_parameter_version')->andReturn(null);
        $this->filesystem->shouldReceive('exists')->with('/base/path/example.css')->andReturn(true);
        $this->filesystem->shouldReceive('lastModified')->with('/base/path/example.css')->andReturn(231);
        $this->url->shouldReceive('asset')->with('example.231.css', null)->andReturn('example.231.css');

        $actual = $this->bust->asset('example.css');

        $this->assertEquals('example.231.css', $actual);
    }

    /**
     * @return void
     */
    public function testAssetCanAppendVersionAsAQueryParameter(): void
    {
        $this->config->shouldReceive('get')->with('bust.base_path')->andReturn('/base/path');
        $this->config->shouldReceive('get')->with('bust.query_parameter_version')->andReturn('v');
        $this->filesystem->shouldReceive('exists')->with('/base/path/example.css')->andReturn(true);
        $this->filesystem->shouldReceive('lastModified')->with('/base/path/example.css')->andReturn(231);
        $this->url->shouldReceive('asset')->with('example.css?v=231', null)->andReturn('example.css?v=231');

        $actual = $this->bust->asset('example.css');

        $this->assertEquals('example.css?v=231', $actual);
    }
}
