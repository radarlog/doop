<?php
declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3;

use Aws\S3\S3ClientInterface;
use Radarlog\Doop\Domain;

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
        $this->client->upload($this->bucketName, $file->hash(), $file->content(), self::ACL, [
            'ContentType' => $file->format()->mime(),
        ]);
    }

    public function get(string $hash): Domain\Image\File
    {
        $hash = new Domain\Image\Hash($hash);

        $command = $this->client->getCommand('GetObject', [
            'Bucket' => $this->bucketName,
            'Key' => (string)$hash,
        ]);

        $content = (string)$this->client->execute($command)->get('Body');

        return new Domain\Image\File($hash, $content);
    }
}
