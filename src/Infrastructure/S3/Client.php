<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Infrastructure\S3;

use Aws\S3\S3ClientInterface;
use Radarlog\S3Uploader\Domain;

final class Client implements Domain\Storage
{
    private const ACL = 'private';

    /** @var S3ClientInterface */
    private $client;

    /** @var string */
    private $bucketName;

    public function __construct(string $bucketName, Connection $connection)
    {
        $this->client = $connection->createS3();
        $this->bucketName = $bucketName;
    }

    public function upload(Domain\Image\File $file): void
    {
        $this->client->upload($this->bucketName, $file->name(), $file->content(), self::ACL, [
            'ContentType' => $file->format()->mime(),
        ]);
    }

    public function list(): \Iterator
    {
        $objects = $this->client->getIterator('ListObjects', [
            'Bucket' => $this->bucketName,
        ]);

        foreach ($objects as $object) {
            yield $object['Key'];
        }
    }

    public function get(string $name): Domain\Image\File
    {
        $command = $this->client->getCommand('GetObject', [
            'Bucket' => $this->bucketName,
            'Key' => $name,
        ]);

        $content = (string)$this->client->execute($command)->get('Body');

        return new Domain\Image\File($name, $content);
    }
}
