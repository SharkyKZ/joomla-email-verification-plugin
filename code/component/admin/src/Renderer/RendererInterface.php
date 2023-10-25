<?php

namespace Sharky\Component\EmailVerification\Administrator\Renderer;

\defined('_JEXEC') || exit;

interface RendererInterface
{
	public function render(string $layout, array $data = []): string;
}
