<?php

namespace Exolnet\Bust;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Filesystem\Filesystem;

class Bust
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected $url;

    /**
     * Bust constructor.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     * @param \Illuminate\Contracts\Routing\UrlGenerator $url
     */
    public function __construct(ConfigRepository $config, Filesystem $filesystem, UrlGenerator $url)
    {
        $this->config = $config;
        $this->filesystem = $filesystem;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->config->get('bust.base_path');
    }

    /**
     * @return string|null
     */
    public function getQueryParameterVersion(): ?string
    {
        return $this->config->get('bust.query_parameter_version');
    }

    /**
     * Generate an asset path for the application with the file's last modification timestamp
     * to avoid cashing.
     *
     * @param  string    $path
     * @param  bool|null $secure
     * @return string
     */
    public function asset(string $path, bool $secure = null): string
    {
        return $this->url->asset($this->path($path), $secure);
    }

    /**
     * @param string $path
     * @return string
     */
    public function path(string $path): string
    {
        $version = $this->version($path);

        if (! $version) {
            return $path;
        }

        return $this->appendVersion($path, $version);
    }

    /**
     * @param string $path
     * @return string|null
     */
    public function version(string $path): ?string
    {
        $fullPath = $this->getBasePath() . DIRECTORY_SEPARATOR . $path;

        if (! $this->filesystem->exists($fullPath)) {
            return null;
        }

        return (string) $this->filesystem->lastModified($fullPath);
    }

    /**
     * @param string $path
     * @return string
     */
    public function filename(string $path): string
    {
        return basename($this->path($path));
    }

    /**
     * @param string $path
     * @param string $version
     * @return string
     */
    protected function appendVersion(string $path, string $version): string
    {
        $versionParameter = $this->getQueryParameterVersion();

        return $versionParameter
            ? $this->appendVersionAsQueryParameter($path, $version, $versionParameter)
            : $this->appendVersionBeforeExtension($path, $version);
    }

    /**
     * @param string $path
     * @param string $version
     * @return string
     */
    protected function appendVersionBeforeExtension(string $path, string $version): string
    {
        $basename = pathinfo($path, PATHINFO_BASENAME);
        $pos = strrpos($basename, '.');

        if ($pos === false) {
            return $path;
        }

        $basenameBust = substr($basename, 0, $pos) . '.' . $version . substr($basename, $pos);
        return substr($path, 0, -strlen($basename)) . $basenameBust;
    }

    /**
     * @param string $path
     * @param string $version
     * @param string $parameter
     * @return string
     */
    protected function appendVersionAsQueryParameter(string $path, string $version, string $parameter): string
    {
        $querySeparator = strpos($path, '?') !== false ? '&' : '?';

        return $path . $querySeparator . http_build_query([$parameter => $version]);
    }
}
