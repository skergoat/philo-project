<?php

namespace App\Service;
use Gedmo\Sluggable\Util\Urlizer;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Asset\Context\RequestStackContext;

class UploaderHelper
{
    private $publicUploadsFilesystem;

    public function __construct(FilesystemInterface $publicUploadsFilesystem, RequestStackContext $requestStackContext)
    {
        $this->filesystem = $publicUploadsFilesystem;
        $this->requestStackContext = $requestStackContext;
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
        $this->filesystem->writeStream(
            $newFilename,
            $stream
        );
        if (is_resource($stream)) {
            fclose($stream);
        }
        // delete old file 
        if ($existingFilename) {
            try {
                $this->filesystem->delete($existingFilename);
            } catch (FileNotFoundException $e) {
            }
        }
        // then return 
        return $newFilename;
    }
}