<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Pedef\Requestor;

use Psr\Http\Message\ResponseInterface;

class ThumbnailRequestor extends BaseRequestor
{

	public function generateThumbnail(): ResponseInterface
	{
		return $this->client->post('thumbnail');
	}

}
