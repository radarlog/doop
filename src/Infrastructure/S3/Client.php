<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\S3;

use Aws\S3\S3ClientInterface;
use Radarlog\S3Uploader\Domain;

final class Client implements Domain\Storage
{
    private const ACL = 'public-read';

    /** @var S3ClientInterface */
    private $client;

    /** @var string */
    private $bucketName;

    public function __construct(string $bucketName, Connection $connection)
    {
        $this->client = $connection->createS3();
        $this->bucketName = $bucketName;
    }

    public function upload(Domain\Image $image): void
    {
        $this->client->upload($this->bucketName, $image->name(), $image->content(), self::ACL);
    }

    public function list(): \Iterator
    {
        $objects = $this->client->getIterator('ListObjects', [
            'Bucket' => $this->bucketName,
        ]);

        foreach ($objects as $object) {
            $key = $object['Key'];

            yield $key => $this->client->getObjectUrl($this->bucketName, $key);
        }
    }
}
