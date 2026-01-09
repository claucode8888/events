<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class ImageUploader
{
  public function __construct(
    private Filesystem $filesystem,
    private string $targetDirectory
  ){}

  public function upload(UploadedFile $file): string
  {
    // $safeName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    // $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '', $safeName);

    $extension = $file->guessExtension() ?? 'bin';
    $filename = uniqid() . '.' . $extension;

    $file->move($this->targetDirectory, $filename);

    return $filename;
  }

  public function replace(UploadedFile $newFile, string|null $oldFilename): string
  {
    if ($oldFilename) {
      $this->delete($oldFilename);
    }

    return $this->upload($newFile);
  }

  public function delete(string|null $filename): void
  {
    if($filename)
    {
      $path = $this->targetDirectory . '/' . $filename;
      if ($this->filesystem->exists($path)) {
        $this->filesystem->remove($path);
      }
    }
  }
}