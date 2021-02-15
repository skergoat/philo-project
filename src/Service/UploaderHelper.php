<?php

namespace App\Service;
use Psr\Log\LoggerInterface;
use Gedmo\Sluggable\Util\Urlizer;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Asset\Context\RequestStackContext;

class UploaderHelper
{
    private $publicUploadsFilesystem;
    private $logger;

    public function __construct(FilesystemInterface $publicUploadsFilesystem, RequestStackContext $requestStackContext, LoggerInterface $logger)
    {
        $this->logger = $logger; // error manager
        $this->filesystem = $publicUploadsFilesystem; // filesystem 
        $this->requestStackContext = $requestStackContext; // path 
    }

    public function getPublicPath(string $path): string
    {
        // needed if you deploy under a subdirectory
        return $this->requestStackContext
            ->getBasePath().'/uploads/'.$path;
    }

    public function uploadArticleImage(File $file, ?string $existingFilename): string
    {
        // get original name 
        if ($file instanceof UploadedFile) {
            $originalFilename = $file->getClientOriginalName();
        } else {
            $originalFilename = $file->getFilename();
        }
        // new file name 
        $newFilename = Urlizer::urlize(pathinfo($originalFilename, PATHINFO_FILENAME)).'-'.uniqid().'.'.$file->guessExtension();
        // memory problem fixed 
        $stream = fopen($file->getPathname(), 'r');
        $result = $this->filesystem->writeStream(
            $newFilename,
            $stream
        );
        if (is_resource($stream)) {
            fclose($stream);
        }
        // delete old file and manage errors 
        if ($existingFilename) {
            try {
                $result = $this->filesystem->delete($existingFilename);
                if ($result === false) {
                    throw new \Exception(sprintf('Could not delete old uploaded file "%s"', $existingFilename));
                }
            } catch (FileNotFoundException $e) {
                $this->logger->alert(sprintf('Old uploaded file "%s" was missing when trying to delete', $existingFilename));
            }
        }
        // then return 
        return $newFilename;
    }
}