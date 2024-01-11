<?php

namespace Sharky\Component\EmailVerification\Administrator\Renderer;

\defined('_JEXEC') || exit;

interface RendererInterface
{
	public function render(string $layout, array $data = []): string;

	public function prependPath(string $path): static;

	public function appendPath(string $path): static;
}
