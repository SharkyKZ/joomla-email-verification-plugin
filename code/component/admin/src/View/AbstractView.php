<?php

namespace Sharky\Component\EmailVerification\Administrator\View;

\defined('_JEXEC') || exit;

use Joomla\CMS\Document\Document;
use Sharky\Component\EmailVerification\Administrator\Renderer\RendererInterface;

abstract class AbstractView implements ViewInterface
{
	protected array $data = [];

	public function __construct(protected RendererInterface $renderer)
	{
	}

	public function addData(string $key, mixed $value): static
	{
		$this->data[$key] = $value;

		return $this;
	}

	abstract public function render(Document $document): string;

	protected function getData(): array
	{
		return $this->data;
	}
}
