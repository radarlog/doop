<?php
declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\S3;

use Aws\S3\S3ClientInterface;
use Radarlog\Doop\Domain;

final class Client implements Domain\Storage
{
    public const PATH_STYLE = true;
    public const HOST_STYLE = false;

    private const ACL = 'private';

    /** @var S3ClientInterface */
    private $client;

    /** @var string */
    private $bucketName;

    public function __construct(string $bucketName, bool $usePathStyle, Connection $connection)
    {
        $this->client = $connection->createS3Client($usePathStyle);
        $this->bucketName = $bucketName;
    }

    public function upload(Domain\Image\File $file): void
    {
        $this->client->upload($this->bucketName, (string)$file->hash(), $file->content(), self::ACL, [
            'ContentType' => $file->format()->mime(),
        ]);
    }

    public function download(string $hash): Domain\Image\File
    {
        $command = $this->client->getCommand('GetObject', [
            'Bucket' => $this->bucketName,
            'Key' => $hash,
        ]);

        $content = (string)$this->client->execute($command)->get('Body');

        return new Domain\Image\File($content);
    }
}
