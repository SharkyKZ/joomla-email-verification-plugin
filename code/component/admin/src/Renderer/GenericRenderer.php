<?php

namespace Sharky\Component\EmailVerification\Administrator\Renderer;

\defined('_JEXEC') || exit;

class GenericRenderer implements RendererInterface
{
    protected array $paths = [];

	public function render(string $layout, array $data = []): string
    {
        $layout = $this->getLayoutFile($layout);

        ob_start();
        (function ()
        {
            extract(func_get_arg(1));

            require func_get_arg(0);
        }) ($layout, $data);

        return ob_get_clean();
    }

    public function prependPath(string $path): static
    {
        $path = $this->normalizePath($path);

        if (!\in_array($path, $this->paths, true))
        {
            array_unshift($this->paths, $path);
        }

        return $this;
    }

    public function appendPath(string $path)
    {
        $path = $this->normalizePath($path);

        if (!\in_array($path, $this->paths, true))
        {
            $this->paths[] = $path;
        }

        return $this;
    }

    private function getLayoutFile(string $layout): string
    {
        $layout = $this->normalizePath($layout);

        foreach ($this->paths as $path)
        {
            $file = $path . '/' . $layout . '.php';

            if (is_file($file))
            {
                return $file;
            }
        }

        throw new \RuntimeException('Layout file not found.');
    }

    private function normalizePath(string $path): string
    {
        $segments = [];
        $path = str_replace(['\\', '//'], ['/', '/'], $path);

        foreach (explode('/', $path) as $segment)
        {
            if ($segment === '' || $segment === '.')
            {
                continue;
            }

            if ($segment === '..')
            {
                if (!$segments)
                {
                    throw new \InvalidArgumentException('Invalid path.');
                }

                array_pop($segments);

                continue;
            }

            $segments[] = $segment;
        }

        return implode('/', $segments);
    }
}
