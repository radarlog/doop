<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3;

use AsyncAws\S3;
use Radarlog\Doop\Domain;

final readonly class Client implements Domain\Storage
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
            'ACL' => S3\Enum\ObjectCannedACL::PRIVATE,
            'Body' => $file->content(),
            'Bucket' => $this->bucketName,
            'ContentType' => $file->format()->mime(),
            'Key' => (string) $file->hash(),
        ]);
    }

    public function download(Domain\Image\Hash $hash): Domain\Image\File
    {
        $input = [
            'Bucket' => $this->bucketName,
            'Key' => (string) $hash,
        ];

        if ($this->client->objectNotExists($input)->isSuccess()) {
            throw Domain\Image\NotFound::hash((string) $hash);
        }

        $object = $this->client->getObject($input);

        $content = $object->getBody()->getContentAsString();

        return new Domain\Image\File($content);
    }

    public function delete(Domain\Image\Hash $hash): void
    {
        $this->client->deleteObject([
            'Bucket' => $this->bucketName,
            'Key' => (string) $hash,
        ]);
    }
}
