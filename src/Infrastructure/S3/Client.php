<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3;

use AsyncAws\S3;
use Radarlog\Doop\Domain;

final class Client implements Domain\Storage
{
    private S3\S3Client $client;

    private string $bucketName;

    public function __construct(string $bucketName, Connection $connection)
    {
        $this->client = new S3\S3Client($connection->configuration());
        $this->bucketName = $bucketName;
    }

    public function upload(Domain\Image\File $file): void
    {
        $this->client->putObject([
            'Bucket' => $this->bucketName,
            'Key' => (string) $file->hash(),
            'Body' => $file->content(),
            'ContentType' => $file->format()->mime(),
            'ACL' => S3\Enum\ObjectCannedACL::PRIVATE,
        ]);
    }

    public function download(string $hash): Domain\Image\File
    {
        $object = $this->client->getObject([
            'Bucket' => $this->bucketName,
            'Key' => $hash,
        ]);

        $content = $object->getBody()->getContentAsString();

        return new Domain\Image\File($content);
    }
}
