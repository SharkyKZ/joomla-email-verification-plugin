<?php

namespace Sharky\Component\EmailVerification\Administrator;

\defined('_JEXEC') || exit;

interface RendererInterface
{
	public function render(string $layout, array $data = []): string;

    public function addPath(string $path): static;
}
